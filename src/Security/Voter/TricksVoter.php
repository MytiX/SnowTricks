<?php

namespace App\Security\Voter;

use App\Tricks\Entity\Tricks;
use PhpParser\Node\Stmt\Return_;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TricksVoter extends Voter
{
    public function supports(string $attribute, $subject)
    {
        return in_array($attribute, ['CAN_EDIT', 'CAN_DELETE']) && $subject instanceof Tricks;
    }

    public function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            return false;
        }

        switch ($attribute) {
            case 'CAN_EDIT':
                return $subject->getUser() === $user;

            case 'CAN_DELETE':
                return $subject->getUser() === $user;
        }

        return false;
    }
}
