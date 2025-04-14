<?php

declare(strict_types=1);

namespace App\EventListener\Doctrine;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: User::class)]
readonly class UserPrePersistEventListener
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    public function prePersist(User $user): void
    {
        $existingUser = $this->userRepository->findOneByEmail($user->getEmail());

        if ($existingUser instanceof User) {
            throw new ConflictHttpException(\sprintf(
                'The email address "%s" is already in use by another user.',
                $user->getEmail(),
            ));
        }
    }
}
