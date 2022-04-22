<?php

namespace App\Security\Controller;

use App\Entity\User;
use App\Form\SignUpType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Symfony\Component\Mime\RawMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SignUpController extends AbstractController
{
    #[Route('/signup', name: 'app_signup')]
    public function __invoke(Request $request, UserRepository $userRepository, UserPasswordHasherInterface  $passwordHasher, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
        $form = $this->createForm(SignUpType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $formUser */
            $formUser = $form->getData();
            
            $user = $userRepository->findOneByEmailOrPseudo($formUser->getEmail(), $formUser->getPseudo());

            if (null === $user) {
                $user = $formUser;
                $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
                $user->setTokenAuth(sha1('token'.$user->getEmail()));
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', "Votre compte a été créé, veuillez confirmer celui par email.");

                $email = (new TemplatedEmail())
                    ->from("contact@snowtricks.fr")
                    ->to($user->getEmail())
                    ->subject('Confirmer votre compte Snowtricks !')
                    ->htmlTemplate('email/create_account.html.twig')
                    ->context([
                        'user' => $user,
                    ]);

                    /** @var RawMessage $email */
                $mailer->send($email);

                return $this->redirectToRoute('app_signin');
            }

            $this->addFlash('error', "L'utilisateur est déjà connue");
        }

        return $this->render('security/signup.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
