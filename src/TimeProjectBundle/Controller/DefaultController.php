<?php

namespace TimeProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TimeProjectBundle\Entity\User;
use TimeProjectBundle\Entity\Projet;


class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
//        $em = $this->getDoctrine()->getManager();
//        $test = $em->getRepository('OCUserBundle:User')->findExempleJan();
//        dump($test[0]->getUsername());



        dump($projets);

        // récupération de l'utilisateur connecté ---> $user = $this->getUser();
        $user = $this->getUser();
        if (empty($user->getLastLogin())){
            return $this->redirectToRoute('/profile/change-password');
        }
        if($user){

            if($user->getRoles()[0] == 'ROLE_ADMIN'){
                $projets = $this->getDoctrine()
                    ->getRepository('TimeProjectBundle:Projet')
                    ->findAll();
            } else {
                $projets = $this->getDoctrine()
                    ->getRepository('TimeProjectBundle:Projet')
                    ->find
            }
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
            dump($user->getRoles());
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
        return $this->render('TimeProjectBundle:Default:project-calendar.html.twig');
    }

    public function createProjectAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $nomProjet = $request->get('nom');
        $dateDebut = $request->get('dateDebut');
        $dateFin = $request->get('dateFin');

        $projet = new Projet();
        $projet->setNom($nomProjet);
//        $projet->setDateDebut(\DateTime::createFromFormat('dd/mm/yyyy', $dateDebut));

        $projet->setDateDebut(new \DateTime($dateDebut));
        $projet->setDateFin(new \DateTime($dateFin));
//        $projet->setDateFin(\DateTime::createFromFormat('dd/mm/yyyy', $dateFin));

        $em->persist($projet);
        $em->flush();

        $response = new Response('Le projet a bien été créé');
        $response->headers->set('Content-Type', 'text/html');
        return $response;
    }
}
