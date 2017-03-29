<?php

namespace TimeProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TimeProjectBundle\Entity\User;
use TimeProjectBundle\Entity\Projet;
use TimeProjectBundle\Entity\Tache;
use TimeProjectBundle\Entity\TacheParUser;


class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        // récupération de l'utilisateur connecté ---> $user = $this->getUser();
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        if($user){
            if (empty($user->getLastLogin())){
                return $this->redirectToRoute('/profile/change-password');
            }
            if($this->isGranted('ROLE_ADMIN')){
                $projets = $this->getDoctrine()
                    ->getRepository('TimeProjectBundle:Projet')
                    ->findAll();
            } else {
                $query = $em->createQueryBuilder('p')
                            ->select('p')
                            ->from('TimeProjectBundle:Projet','p')
                            ->from('TimeProjectBundle:Tache','t')
                            ->from('TimeProjectBundle:TacheParUser','tu')
                            ->where('tu.fkUser = :userid')
                            ->setParameter('userid', $user->getId())
                            ->andWhere('t.id = tu.fkTache')
                            ->andWhere('t.fkProjet = p.id')
                            ->groupBy('p.id')
                            ->getQuery();

                $projets = $query->getResult();
            }
            dump($projets);
            return $this->render('TimeProjectBundle:Default:index.html.twig', ['projets' => $projets]);
        } else {
            return $this->redirectToRoute('login');
        }
    }

    public function loginAction()
    {
        return $this->render('TimeProjectBundle:Default:login.html.twig');
    }

    public function createUserAction(){
        return $this->render('TimeProjectBundle:Default:createUser.html.twig');
    }

    public function getAllUsersAction(){
        $allUsers = $this->getDoctrine()
                         ->getRepository('TimeProjectBundle:User')
                         ->findAll();
        $arrayUsers = null;
        foreach ( $allUsers as $key => $user ){
            $arrayUsers['data'][$key]['DT_RowId'] = 'row_'.$user->getId();
            $arrayUsers['data'][$key]['id'] = $user->getId();
            $arrayUsers['data'][$key]['username'] = $user->getUsername();
            $arrayUsers['data'][$key]['email'] = $user->getEmail();
            foreach($user->getRoles() as $role){
                $role = ($role == 'ROLE_ADMIN' ? 'ADMIN' : 'UTILISATEUR');
            }

            $arrayUsers['data'][$key]['role'] = $role;
        }
        $response = new Response(json_encode($arrayUsers));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function manageUserAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $data = null;

        foreach($request->get('data') as $data){
            $data = $data;
        }
        $role = ($data['role'] == 'ADMIN' ? 'ROLE_ADMIN' : 'ROLE_USER');
        $action = $request->get('action');
        if ( $action == 'create' ){
            $user = new User();
            $user->setUsername($request->get('data')[0]['username']);
            $user->setEmail($request->get('data')[0]['email']);
            $user->setUsernameCanonical($request->get('data')[0]['username']);
            $user->setEmailCanonical($request->get('data')[0]['email']);
            $user->setRoles([$role]);
            $token = random_bytes(10);
            $user->setConfirmationToken($token);
            // a revoir
            $user->setPassword('azerty');
            $user->setSalt('azertyuiokjhgdsdfghjkjhgfd');
            $user->setEnabled(true);

            $em->persist($user);

            $url = $this->get('router')->generate('fos_user_registration_confirm', array('token' => $user->getConfirmationToken()), UrlGeneratorInterface::ABSOLUTE_URL);

            $message = \Swift_Message::newInstance()
                                     ->setSubject('Bienvenu '.$user->getUsername())
                                     ->setFrom('contact.timeproject@gmail.com')
                                     ->setTo($user->getEmail())
                                     ->setBody(
                                         $this->renderView(
                                             'TimeProjectBundle:Email:confirmEmail.html.twig',
                                             ['user' => $user->getUsername(),
                                              'email'=>$user->getEmail(),
                                              'password' => $user->getPassword(),
                                              'url' => $url
                                             ]
                                         ),
                                         'text/html'
                                     )
                /*
                 * If you also want to include a plaintext version of the message
                ->addPart(
                    $this->renderView(
                        'Emails/registration.txt.twig',
                        array('name' => $name)
                    ),
                    'text/plain'
                )
                */
            ;
            $this->get('mailer')->send($message);

        } else if ( $action == 'edit' ){
            $user = $this->getDoctrine()
                ->getRepository('TimeProjectBundle:User')
                ->find($data['id']);
            $user->setUsername($data['username']);
            $user->setEmail($data['email']);
            $user->setUsernameCanonical($data['username']);
            $user->setEmailCanonical($data['email']);
            $user->setRoles([$role]);
            $em->persist($user);

        } else {
            $user = $this->getDoctrine()
                ->getRepository('TimeProjectBundle:User')
                ->find($data['id']);
            $em->remove($user);
        }

        $em->flush();

        foreach($user->getRoles() as $role){
            $role = ($role == 'ROLE_ADMIN' ? 'ADMIN' : 'UTILISATEUR');
        }

        $data['data'][] = [
            'DT_RowId' => 'row_'.$user->getId(),
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'role' => $role,
        ];

        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function getProjectCalendarAction($project_id){
        $em = $this->getDoctrine()->getManager();
        $projet = $this->getDoctrine()
            ->getRepository('TimeProjectBundle:Projet')
            ->find($project_id);
        if($projet){
            if(!$this->isGranted('ROLE_ADMIN')) {
                $user = $this->getUser();
                $query = $em->createQueryBuilder('p')
                    ->select('p')
                    ->from('TimeProjectBundle:Projet','p')
                    ->from('TimeProjectBundle:Tache','t')
                    ->from('TimeProjectBundle:TacheParUser','tu')
                    ->where('p.id = :projetid')
                    ->setParameter('projetid', $project_id)
                    ->andWhere('tu.fkUser = :userid')
                    ->setParameter('userid', $user->getId())
                    ->andWhere('tu.fkTache = t.id')
                    ->andWhere('t.fkProjet = p.id')
                    ->getQuery();
                $projet = $query->getOneOrNullResult();
                if($projet == NULL){
                    return $this->redirectToRoute('page_introuvable');
                }
                $allUsers = null;
            } else {
                $allUsers = $this->getDoctrine()
                                ->getRepository('TimeProjectBundle:User')
                                ->findAll();
            }
            return $this->render('TimeProjectBundle:Default:project-calendar.html.twig',
                ['projet'=>$projet, 'allUsers'=>$allUsers]);
        } else {
            return $this->redirectToRoute('page_introuvable');
        }
    }

    public function createProjectAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $nomProjet = $request->get('nom');
        $dateDebut = new \DateTime($request->get('dateDebut'));
        $dateFin = new \DateTime($request->get('dateFin'));

        if ($dateDebut < $dateFin ){
            $projet = new Projet();
            $projet->setNom($nomProjet);
            $projet->setDateDebut($dateDebut);
            $projet->setDateFin($dateFin);
            $em->persist($projet);
            $em->flush();
            $response = new Response("Le projet a bien été créé");
        } else {
            $response = new Response("Erreur ! La date de début doit être antérieur à la date de fin !");
        }
        $response->headers->set('Content-Type', 'text/html');
        return $response;
    }

    public function createTacheAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $nomTache = $request->get('nom');
        $dateDebut = new \DateTime($request->get('dateDebut'));
        $dateFin = new \DateTime($request->get('dateFin'));
        $priorite = $request->get('priorite');
        $projetId = $request->get('projetId');
        $usersToTache = $request->get('usersToTache');

        if ($dateDebut < $dateFin ){
            $projet = $this->getDoctrine()
                ->getRepository('TimeProjectBundle:Projet')
                ->find($projetId);

            $tache = new Tache();
            $tache->setNom($nomTache);
            $tache->setDateDebut($dateDebut);
            $tache->setDateFin($dateFin);
            $tache->setPriorite($priorite);
            $tache->setFkProjet($projet);
            $em->persist($tache);
            foreach($usersToTache as $userByTache){
                $fkUser = $this->getDoctrine()
                    ->getRepository('TimeProjectBundle:User')
                    ->find($userByTache['userId']);
                $tacheParUser = new TacheParUser();
                $tacheParUser->setFkUser($fkUser);
                $tacheParUser->setFkTache($tache);
                $tacheParUser->setDuree($userByTache['duree']);
                $em->persist($tacheParUser);
            }
            $em->flush();
            $response = new Response("La tâche a bien été créé");
        } else {
            $response = new Response("Erreur ! La date de début doit être antérieur à la date de fin !");
        }
        $response->headers->set('Content-Type', 'text/html');
        return $response;
    }

    public function editTacheAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $nomTache = $request->get('nom');
        $dateDebut = new \DateTime($request->get('dateDebut'));
        $dateFin = new \DateTime($request->get('dateFin'));
        $priorite = $request->get('priorite');
        $tacheId = $request->get('tacheId');
        $projetId = $request->get('projetId');
        $usersToTache = $request->get('usersToTache');

        if ($dateDebut < $dateFin ){
            $tache = $this->getDoctrine()
                ->getRepository('TimeProjectBundle:Tache')
                ->find($tacheId);
            $tache->setNom($nomTache);
            $tache->setDateDebut($dateDebut);
            $tache->setDateFin($dateFin);
            $tache->setPriorite($priorite);
            $em->persist($tache);

            // supprimer les taches associées aux utilisateurs avant d'ajouter les nouvelles modifiées !!!
            $allTacheParUser = $this->getDoctrine()
                ->getRepository('TimeProjectBundle:TacheParUser')
                ->findBy(['fkTache'=> $tache]);
            foreach($allTacheParUser as $value){
                $em->remove($value);
            }
            foreach($usersToTache as $userByTache){
                $fkUser = $this->getDoctrine()
                    ->getRepository('TimeProjectBundle:User')
                    ->find($userByTache['userId']);
                $tacheParUser = new TacheParUser();
                $tacheParUser->setFkUser($fkUser);
                $tacheParUser->setFkTache($tache);
                $tacheParUser->setDuree($userByTache['duree']);
                $em->persist($tacheParUser);
            }
            $em->flush();
            $response = new Response("La tâche a bien été modifiée");
        } else {
            $response = new Response("Erreur ! La date de début doit être antérieur à la date de fin !");
        }
        $response->headers->set('Content-Type', 'text/html');
        return $response;
    }

    public function pageIntrouvableAction(){
        return $this->render('TimeProjectBundle:Default:error-404.html.twig');
    }

    public function getTachesAction($projetId, $priorite){
        $array = null ;
        $em = $this->getDoctrine()->getManager();
        if($this->isGranted('ROLE_ADMIN')){
            $query = $em->createQueryBuilder('t')
                ->select('t')
                ->from('TimeProjectBundle:Tache','t')
                ->where('t.fkProjet = :projetid')
                ->setParameter('projetid', $projetId)
                ->andWhere('t.priorite = :priorite')
                ->setParameter('priorite', $priorite)
                ->getQuery();
            $taches = $query->getResult();
        } else {
            $user = $this->getUser();
            $query = $em->createQueryBuilder('t')
                ->select('t')
                ->from('TimeProjectBundle:Tache','t')
                ->from('TimeProjectBundle:TacheParUser','tu')
                ->where('t.fkProjet = :projetid')
                ->setParameter('projetid', $projetId)
                ->andWhere('tu.fkUser = :userid')
                ->setParameter('userid', $user->getId())
                ->andWhere('tu.fkTache = t.id')
                ->andWhere('t.priorite = :priorite')
                ->setParameter('priorite', $priorite)
                ->getQuery();
            $taches = $query->getResult();
        }

        foreach( $taches as $key => $tache ){
            $array[$key]['id'] = $tache->getId();
            $array[$key]['allDay'] = 'false';
            $array[$key]['title'] = $tache->getNom();
            $array[$key]['start'] = $tache->getDateDebut()->format('Y-m-d');
            $array[$key]['end'] = $tache->getDateFin()->format('Y-m-d');
            $array[$key]['priorite'] = $tache->getPriorite();
            $array[$key]['dateDebut'] =$tache->getDateDebut()->format('d/m/Y');
            $array[$key]['dateFin'] = $tache->getDateFin()->format('d/m/Y');
            $allTacheParUser = $this->getDoctrine()
                ->getRepository('TimeProjectBundle:TacheParUser')
                ->findBy(['fkTache'=> $tache]);
            foreach($allTacheParUser as $keyy => $value){
                $array[$key]['users'][$keyy]['userid'] = $value->getFkUser()->getId();
                $array[$key]['users'][$keyy]['username'] = $value->getFkUser()->getUsername();
                $array[$key]['users'][$keyy]['duree'] = $value->getDuree();
            }
        }
        $response = new Response(json_encode($array));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
