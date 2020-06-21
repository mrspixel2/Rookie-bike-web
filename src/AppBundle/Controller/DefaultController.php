<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
class DefaultController extends Controller
{
    private $tokenManager;

    public function __construct(CsrfTokenManagerInterface $tokenManager = null)
    {
        $this->tokenManager = $tokenManager;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        if($this->get('security.authorization_checker')->isGranted("ROLE_ADMIN"))
        {return $this->render('back.html.twig');}
        if($this->get('security.authorization_checker')->isGranted("IS_AUTHENTICATED_ANONYMOUSLY")) {
        $csrfToken = $this->tokenManager
        ? $this->tokenManager->getToken('authenticate')->getValue()
        : null;
        return $this->render('base.html.twig',array(
            'csrf_token' => $csrfToken,
        )   ); } 
      
    }
}
