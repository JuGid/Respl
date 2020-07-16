<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
      return $this->render('index.html.twig');
    }

    /**
     * @Route("/dashboard", name="app_dashboard")
     * @IsGranted("ROLE_USER")
     */
    public function dashboard() {
      return $this->render('dashboard.html.twig');
    }
}
