<?php

namespace App\Security;

use App\Entity\User;
use App\Entity\Snowtrick;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class SnowtrickVoter extends Voter
{
    const EDIT = 'edit';
    const DELETE = 'delete';
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::DELETE, self::EDIT])) {
            return false;
        }

        // only vote on `Snowtrick` objects
        if (!$subject instanceof Snowtrick) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        // you know $subject is a Snowtrick object, thanks to `supports()`
        /** @var Snowtrick $snowtrick */
        $snowtrick = $subject;

        return match($attribute) {
            self::EDIT => $this->canEdit($snowtrick, $user),
            self::DELETE => $this->canDelete($snowtrick, $user),
            default => throw new \LogicException('Ce voteur ne devrait pas être atteint.')
        };
    }

    private function canEdit(Snowtrick $snowtrick, User $user): bool
    {
        return $user === $snowtrick->getUser();
    }

    private function canDelete(Snowtrick $snowtrick, User $user): bool
    {
        return $user === $snowtrick->getUser();
    }
}
