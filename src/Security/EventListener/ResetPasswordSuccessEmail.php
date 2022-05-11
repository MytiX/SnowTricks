<?php

namespace App\Security\EventListener;

use App\Event\ResetPasswordEvent;
use Symfony\Component\Mime\RawMessage;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class ResetPasswordSuccessEmail
{
    public function __construct(private MailerInterface $mailer, private string $contactFrom) {}

    public function __invoke(ResetPasswordEvent $resetPasswordEvent)
    {
        $user = $resetPasswordEvent->getUser();

        /** @var RawMessage $email */
        $email = (new TemplatedEmail())
            ->from($this->contactFrom)
            ->to($user->getEmail())
            ->subject('Votre mot de passe à bien été réinitialisé')
            ->htmlTemplate('email/reset_password.html.twig')
            ->context([
                'user' => $user,
            ]
        );

        $this->mailer->send($email);
    }
}
