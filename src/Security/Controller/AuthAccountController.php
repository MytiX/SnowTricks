<?php
namespace App\Security\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthAccountController extends AbstractController
{
    #[Route('/auth/account/{email}/{tokenAuth}', name: 'app_auth_account')]
    public function test(string $email, string $tokenAuth)
    {
        dd('La');
    }
}