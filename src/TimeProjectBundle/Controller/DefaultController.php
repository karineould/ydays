<?php

namespace TimeProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


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
            if($admin->getIdsociete() == null){
                return $this->render('TimeProjectBundle:Default:createSociety.html.twig');
            }
            return $this->render('TimeProjectBundle:Default:index.html.twig', ['missions' => [] ]);
        } else {
            return $this->redirectToRoute('login');
        }
    }

    public function loginAction()
    {
        return $this->render('TimeProjectBundle:Default:login.html.twig');
    }

    public function createSocietyAction(){
        return $this->render('TimeProjectBundle:Default:societyConf.html.twig');
    }
}
