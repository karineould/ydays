<?php

namespace TimeProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use OCUserBundle\Entity\User;
use TimeProjectBundle\Entity\Projet;
use TimeProjectBundle\Entity\Tache;
use TimeProjectBundle\Entity\TacheParUser;
use Symfony\Component\Config\Definition\Exception\Exception;


class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        // récupération de l'utilisateur connecté ---> $user = $this->getUser();
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $projets = [];
        if($user){
            if ($user->getLastLogin() == null){
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
                            ->orderBy('p.dateFin', 'ASC')
                            ->getQuery();

                $projets = $query->getResult();
            }

            //Sort projet by date end
            usort($projets, function( $a, $b ) {
                return ($a->getDateFin()) > ($b->getDateFin());
            });

            $taches =[];
            foreach ($projets as $projet){
                $query = $em->createQueryBuilder('t')
                            ->select('t')
                            ->from('TimeProjectBundle:Tache','t')
                            ->where('t.fkProjet = :projetId')
                            ->setParameter('projetId', $projet->getId())
                            ->andWhere('t.dateFin = :now')
                            ->setParameter('now', (new \DateTime())->format('Y-m-d'))
                            ->orderBy('t.priorite', 'DESC')
                            ->getQuery();

                $tacheUrgente = $query->getResult();
                $taches[$projet->getId()] = $tacheUrgente;
            }
            return $this->render('TimeProjectBundle:Default:index.html.twig', ['projets' => $projets, 'user' => $user, 'taches' => $taches]);
        } else {
            return $this->redirectToRoute('login');
        }
    }

    public function loginAction()
    {
        return $this->render('TimeProjectBundle:Default:login.html.twig');
    }

    public function createUserAction(){
        $currentUser = $this->getUser();
        $allUsers = $this->getDoctrine()
                         ->getRepository('TimeProjectBundle:User')
                         ->findAll();
        $arrayUsers = [];
        foreach ( $allUsers as $key => $user ){
            foreach($user->getRoles() as $role){
                $role = ($role == 'ROLE_ADMIN' ? 'ADMIN' : 'UTILISATEUR');
            }
            $userArray = [$user->getUsername(), $user->getEmail(), $role, $user->getId()];
            $arrayUsers[] = $userArray;
        }

        return $this->render('TimeProjectBundle:Default:createUser.html.twig', ['users' => $arrayUsers, 'user' => $currentUser]);
    }

    public function getAllUsersAction(){
        $allUsers = $this->getDoctrine()
                         ->getRepository('TimeProjectBundle:User')
                         ->findAll();
        $arrayUsers = [];
        foreach ( $allUsers as $key => $user ){
            foreach($user->getRoles() as $role){
                $role = ($role == 'ROLE_ADMIN' ? 'ADMIN' : 'UTILISATEUR');
            }
            $userArray = [$user->getUsername(), $user->getEmail(), $role, $user->getId()];
            $arrayUsers[] = $userArray;
        }

        $response = new Response(json_encode($arrayUsers));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function manageUserAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $data = $request->get('data');
        $action = $request->get('action');
        $output = [];

        if ( $action == 'create' ){
            //Create the user
            try {
                $role[] = ($data[0]['role'] == 'ADMIN' ? 'ROLE_ADMIN' : 'ROLE_USER');
                $user = new User();
                $user->setUsername($data[0]['username']);
                $user->setEmail($data[0]['email']);
                $user->setUsernameCanonical($data[0]['username']);
                $user->setEmailCanonical($data[0]['email']);
                $user->setConfirmationToken(md5(uniqid(rand(), true)));

                // Initialize the password
                $plainPassword = 'azerty';
                $encoder       = $this->get('security.password_encoder');
                $encoded       = $encoder->encodePassword($user, $plainPassword);
                $user->setPassword($encoded);
                $user->setEnabled(false);
                $user->setRoles($role);

                $em->persist($user);
                $em->flush();

                //Send confirmation email
                $url = $this->get('router')->generate('fos_user_registration_confirm', array('token' => $user->getConfirmationToken()), UrlGeneratorInterface::ABSOLUTE_URL);
                $message = \Swift_Message::newInstance()
                                         ->setSubject('Bienvenue '.$user->getUsername())
                                         ->setFrom('contact.timeproject@gmail.com')
                                         ->setTo($user->getEmail())
                                         ->setBody(
                                             $this->renderView(
                                                 'TimeProjectBundle:Email:confirmEmail.html.twig',
                                                 ['user' => $user->getUsername(),
                                                  'email'=>$user->getEmail(),
                                                  'password' => $plainPassword,
                                                  'url' => $url
                                                 ]
                                             ),
                                             'text/html'
                                         );
                $this->get('mailer')->send($message);

                $output['success'] =  "L'utilisateur a été créé";
            }catch (Exception $e) {
                $output["error"] = "L'utilisateur n'a pas été créé";

                $response = new Response(json_encode($output));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            }
        } else if ( $action == 'edit' ){
            //Update the user data
            try {
                $role = ($data[0]['role'] == 'ADMIN' ? 'ROLE_ADMIN' : 'ROLE_USER');
                $user = $this->getDoctrine()
                             ->getRepository('TimeProjectBundle:User')
                             ->find($data[0]['id']);
                $user->setUsername($data[0]['username']);
                $user->setEmail($data[0]['email']);
                $user->setUsernameCanonical($data[0]['username']);
                $user->setEmailCanonical($data[0]['email']);
                $user->setRoles([$role]);

                $em->persist($user);
                $em->flush();

                $output['success'] =  "L'utilisateur a été modifié";
            }catch (Exception $e) {
                $output["erreur"] = "L'utilisateur n'a pas été modifié";
                $response = new Response(json_encode($output));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            }
        } else {
            //Check if the user is related to a task
            $userTasks = $this->getDoctrine()
                             ->getRepository('TimeProjectBundle:TacheParUser')
                             ->findBy(['fkUser' => $data[0]['id']]);

            //if  not delete the user
            if (!$userTasks){
                try{
                    $user = $this->getDoctrine()
                                ->getRepository('TimeProjectBundle:User')
                                ->find($data[0]['id']);
                    $em->remove($user);
                    $em->flush();

                    $output['success'] =  "L'utilisateur a été supprimé";
                }catch (Exception $e) {
                    $output["erreur"] = "L'utilisateur n'a pas été supprimé";

                    $response = new Response(json_encode($output));
                    $response->headers->set('Content-Type', 'application/json');
                    return $response;
                }

            }else{
                $output["erreur"] = "L'utilisateur est relié a une tache !";

                $response = new Response(json_encode($output));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            }

        }

        $response = new Response(json_encode($output));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getProjectCalendarAction($project_id){
        $user = $this->getUser();
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
                ['projet'=>$projet, 'allUsers'=>$allUsers, 'user' => $user]);
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
        $user = $this->getUser();
        $fkUser = $this->getDoctrine()
                       ->getRepository('TimeProjectBundle:User')
                       ->find($user->getId());
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
            $tache->setRedacteur($fkUser);
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
        $user = $this->getUser();
        $fkUser = $this->getDoctrine()
                       ->getRepository('TimeProjectBundle:User')
                       ->find($user->getId());
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
            $tache->setRedacteur($fkUser);
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
            $redacteur = $this->getDoctrine()
                             ->getRepository('TimeProjectBundle:User')
                             ->find($tache->getRedacteur());
            
            $array[$key]['id'] = $tache->getId();
            $array[$key]['allDay'] = 'false';
            $array[$key]['title'] = $redacteur->getUsername().' : '.$tache->getNom();
            $array[$key]['start'] = $tache->getDateDebut()->format('Y-m-d');
            $array[$key]['end'] = $tache->getDateFin()->format('Y-m-d');
            $array[$key]['priorite'] = $tache->getPriorite();
            $array[$key]['redacteur'] = $redacteur->getUsername();
            $array[$key]['dateDebut'] = $tache->getDateDebut()->format('d/m/Y');
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


    public function listPlanAction($project_id){
//        $em = $this->getDoctrine()->getManager();
        $projet = $this->getDoctrine()
                       ->getRepository('TimeProjectBundle:Projet')
                       ->find($project_id);
        if($projet) {
            return $this->render('TimeProjectBundle:Default:listPlan.html.twig',['projet' => $projet] );
        }
    }
}
