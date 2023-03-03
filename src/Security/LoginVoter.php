<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class LoginVoter extends Voter
{
    const CONNECTED = 'connected';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::CONNECTED])) {
            return false;
        }

        // only vote on `Snowtrick` objects
        if ($subject instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        /** @var User $user */
        $user = $subject;

        return match($attribute) {
            self::CONNECTED => $this->canAccess($user),
            default => throw new \LogicException('Ce voteur ne devrait pas être atteint.')
        };
    }

    private function canAccess(?User $user): bool
    {
        if($user == null) {
            return true;
        }
    }
}
