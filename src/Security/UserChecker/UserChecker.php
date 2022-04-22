<?php
namespace App\Security\UserChecker;

use App\Entity\User;
use Symfony\Component\Mime\RawMessage;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;

class UserChecker implements UserCheckerInterface 
{
    public function __construct(private MailerInterface $mailer) {}

    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }

        if (!$user->getActive()) {
            // the message passed to this exception is meant to be displayed to the user
            throw new CustomUserMessageAccountStatusException('Vous n\'avez pas activer votre compte par email.');
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }

        $email = (new TemplatedEmail())
            ->from("contact@snowtricks.fr")
            ->to($user->getEmail())
            ->subject('Connexion détectée à votre compte Snowtricks')
            ->htmlTemplate('email/new_connexion.html.twig');

            /** @var RawMessage $email */
        $this->mailer->send($email);
    }
}
