<?php

namespace App\Security\Controller;

use App\Event\ResetPasswordEvent;
use DateTime;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ResetPasswordController extends AbstractController
{
    #[Route('/reset-password/{email}/{resetPassword}', name: 'app_reset_password')]
    public function __invoke(string $email, string $resetPassword, UserRepository $userRepository, Request $request, UserPasswordHasherInterface  $passwordHasher, EntityManagerInterface $em, EventDispatcherInterface $dispatcher): Response
    {
        $user = $userRepository->findOneBy([
            'email' => $email
        ]);

        if (null === $user OR $user->getResetPassword() !== $resetPassword) {
            $this->addFlash('error', 'Une erreur est survenu, veuillez refaire la demande pour réinitialiser votre mot de passe.');
            return $this->redirectToRoute('app_forgot_password');
        }

        $now = new DateTime();

        if ($now > $user->getResetPasswordExpireAt()) {
            $this->addFlash('error', 'Votre demande de réinitialisation de mot de passe à expiré, veuillez refaire votre demande.');
            return $this->redirectToRoute('app_forgot_password');
        }

        $form = $this->createForm(ResetPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->getData()['password'];
            $user->setPassword($passwordHasher->hashPassword($user, $password));
            $em->flush();
            $this->addFlash('success', 'Votre mot de passe est maintenant réinitialisé.');
            $dispatcher->dispatch(new ResetPasswordEvent($user), 'user.reset.password.success');
            return $this->redirectToRoute('app_signin');
        }

        return $this->render('reset_password/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
