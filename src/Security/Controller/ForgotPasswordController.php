<?php

namespace App\Security\Controller;

use App\Event\ResetPasswordEvent;
use App\Form\ForgotPasswordType;
use App\Repository\UserRepository;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForgotPasswordController extends AbstractController
{
    #[Route('/forgot-password', name: 'app_forgot_password')]
    public function __invoke(Request $request, UserRepository $userRepository, EntityManagerInterface $em, EventDispatcherInterface $dispatcher): Response
    {
        $form = $this->createForm(ForgotPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() AND $form->isValid()) {
            $pseudo = $form->getData()['pseudo'];

            $user = $userRepository->findOneBy([
                'pseudo' => $pseudo,
            ]);

            if (null === $user) {
                $this->addFlash('error', "Il semblerait que nous ne connaissions pas ce pseudo !");
            } else {
                $now = new DateTime();
                $user->setResetPassword(sha1('reset-password'));
                $user->setResetPasswordExpireAt($now->add(DateInterval::createFromDateString('900 seconds')));
                $em->flush();
                $this->addFlash('success', "Un email pour réinitialiser votre mot de passe vous a été envoyé, attention il expira dans 15 min.");
                $dispatcher->dispatch(new ResetPasswordEvent($user), 'user.forgot.password.success');
            }
        }

        return $this->render('forgot_password/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
