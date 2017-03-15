<?php

namespace TimeProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TimeProjectBundle\Entity\User;


class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
//        $em = $this->getDoctrine()->getManager();
//        $test = $em->getRepository('OCUserBundle:User')->findExempleJan();
//        dump($test[0]->getUsername());

        // récupération de l'utilisateur connecté ---> $user = $this->getUser();
        $user = $this->getUser();
        if($user){
            $admin = $this->getDoctrine()
                            ->getRepository('TimeProjectBundle:Admin')
                            ->findOneByIduser(["iduser" => $user->getId()]);
//            dump($admin);
            return $this->render('TimeProjectBundle:Default:index.html.twig', ['missions' => []]);
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

            // a revoir
            $user->setPassword('azerty');
            $user->setSalt('azertyuiokjhgdsdfghjkjhgfd');
            $user->setEnabled(true);

            $em->persist($user);

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
}
