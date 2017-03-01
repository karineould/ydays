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
            $arrayUsers['data'][$key]['username'] = $user->getUsername();
            $arrayUsers['data'][$key]['email'] = $user->getEmail();
        }
        $response = new Response(json_encode($arrayUsers));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function manageUserAction(Request $request){
        $action = $request->get('action');
        if ( $action == 'create' ){
            $user = new User();
            $user->setUsername($request->get('data')[0]['username']);
            $user->setEmail($request->get('data')[0]['email']);
            $user->setPassword('azerty');
            $user->setUsernameCanonical($request->get('data')[0]['username']);
            $user->setEmailCanonical($request->get('data')[0]['email']);
            $user->setRoles(['ROLE_USER']);
            $user->setSalt('azertyuiokjhgdsdfghjkjhgfd');
            $user->setEnabled(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

        } else if ( $action == 'edit' ){

        } else {

        }

        $data['data'][] = [
            'DT_RowId' => 'row_'.$user->getId(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail()
        ];

        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
