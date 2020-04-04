<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        if($this->get('security.authorization_checker')->isGranted("ROLE_ADMIN"))
        {return $this->render('back.html.twig');}
        if($this->get('security.authorization_checker')->isGranted("IS_AUTHENTICATED_ANONYMOUSLY"))
        {return $this->render('base.html.twig');}
    }
}
