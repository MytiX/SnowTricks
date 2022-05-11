<?php

namespace App\Security\EventListener;

use App\Event\UserSignInSuccessEvent;
use Symfony\Component\Mime\RawMessage;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class UserSignInSuccessEmailListener
{
    public function __construct(private MailerInterface $mailer, private string $contactFrom) {}

    public function __invoke(UserSignInSuccessEvent $userSignInSuccessEvent)
    {
        $user = $userSignInSuccessEvent->getUser();

        /** @var RawMessage $email */
        $email = (new TemplatedEmail())
            ->from($this->contactFrom)
            ->to($user->getEmail())
            ->subject('Connexion détectée à votre compte Snowtricks')
            ->htmlTemplate('email/new_connexion.html.twig');
            
        $this->mailer->send($email);
    }

}
