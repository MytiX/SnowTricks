<?php
namespace App\Security\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthAccountController extends AbstractController
{
    #[Route('/auth/account/{email}/{tokenAuth}', name: 'app_auth_account')]
    public function test(string $email, string $tokenAuth, UserRepository $userRepository, EntityManagerInterface $em)
    {
        $user = $userRepository->findOneBy([
            'email' => $email,
            'tokenAuth' => $tokenAuth,
        ]);

        if (null === $user) {
            $this->addFlash('error', "Une erreur c'est produite lors de votre vérification, nous venons de vous renvoyer un email de vérification.");
            return $this->redirectToRoute('app_signin');
        }

        $user->setActive(true);

        $em->flush();

        $this->addFlash('success', 'Votre compte est maintenant activé.');

        return $this->redirectToRoute('app_signin');
    }
}