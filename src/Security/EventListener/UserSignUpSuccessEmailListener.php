<?php

namespace App\Security\EventListener;


use App\Event\UserSignUpSuccessEvent;
use Symfony\Component\Mime\RawMessage;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class UserSignUpSuccessEmailListener
{
    public function __construct(private MailerInterface $mailer, private string $contactFrom){}

    public function __invoke(UserSignUpSuccessEvent $userRegisterSuccessEvent)
    {
        $user = $userRegisterSuccessEvent->getUser();
        
        /** @var RawMessage $email */
        $email = (new TemplatedEmail())
            ->from($this->contactFrom)
            ->to($user->getEmail())
            ->subject('Confirmer votre compte Snowtricks !')
            ->htmlTemplate('email/create_account.html.twig')
            ->context([
                'user' => $user,
            ]
        );

        $this->mailer->send($email);
    }
}
