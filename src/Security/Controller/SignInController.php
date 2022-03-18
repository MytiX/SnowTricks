<?php

namespace App\Security\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignInController extends AbstractController
{
    #[Route('/signin', name: 'app_signin')]
    public function index(): Response
    {
        return $this->render('sign_in/index.html.twig');
    }
}
