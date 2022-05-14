<?php

namespace App\Security\Voter;

use App\Media\Entity\Media;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class MediaVoter extends Voter
{
    public function supports(string $attribute, $subject)
    {
        return in_array($attribute, ['CAN_DELETE', 'CAN_EDIT']) && $subject instanceof Media;
    }

    public function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'CAN_DELETE':
                return $subject->getTricks()->getUser() === $user;
            case 'CAN_EDIT':
                return $subject->getTricks()->getUser() === $user;
        }
        return false;
    }
}