<?php

namespace TimeProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $test = $em->getRepository('OCUserBundle:User')->findExempleJan();
        
        dump($test[0]->getUsername());
        
        return $this->render('TimeProjectBundle:Default:index.html.twig', ['missions' => [] ]);
    }

    public function loginAction()
    {
        return $this->render('TimeProjectBundle:Default:login.html.twig');
    }
}
