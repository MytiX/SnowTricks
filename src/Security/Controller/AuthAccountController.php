<?php
namespace App\Security\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthAccountController extends AbstractController
{
    #[Route('/auth/account/{email}/{tokenAuth}', name: 'app_auth_account')]
    public function __invoke(string $email, string $tokenAuth, UserRepository $userRepository, EntityManagerInterface $em)
    {
        $user = $userRepository->findOneBy([
            'email' => $email,
            'tokenAuth' => $tokenAuth,
        ]);

        if (null === $user) {
            $this->addFlash('error', 'Une erreur est survenue lors de votre authentification, un email vous a été envoyé.');
            return $this->redirectToRoute('app_signin');
        }

        if (false === $user->getActive()) {
            $user->setActive(true);
            $em->flush();
        }

        $this->addFlash('success', 'Votre compte à été validé.');
        return $this->redirectToRoute('app_signin');
    }
}