<?php

namespace TimeProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TimeProjectBundle:Default:index.html.twig');
    }

    public function loginAction()
    {
        return $this->render('TimeProjectBundle:Default:login.html.twig');
    }
}
