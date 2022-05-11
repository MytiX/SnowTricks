<?php

namespace App\Security\Controller;

use App\Entity\User;
use App\Form\SignUpType;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Event\UserSignUpSuccessEvent;
use Symfony\Component\Mime\RawMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SignUpController extends AbstractController
{
    #[Route('/signup', name: 'app_signup')]
    public function __invoke(Request $request, UserRepository $userRepository, UserPasswordHasherInterface  $passwordHasher, EntityManagerInterface $em, EventDispatcherInterface $dispatcher): Response
    {
        $user = $this->getUser();

        if (null !== $user) {
            return $this->redirectToRoute('app_home');
        }

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
                $this->addFlash('success', "Votre compte a été créé, veuillez confirmer celui-ci par email.");

                $dispatcher->dispatch(new UserSignUpSuccessEvent($user), 'user.signup.success');

                return $this->redirectToRoute('app_signin');
            }

            $this->addFlash('error', "L'utilisateur est déjà connue");
        }

        return $this->render('security/signup.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
