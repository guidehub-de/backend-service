<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Safe\DateTimeImmutable;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/** @implements ProcessorInterface<User, User> */
class ConfirmUserProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    /** @param User $data */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): User
    {
        $persistedUser = $this->userRepository->find($data);
        if (!$persistedUser instanceof User) {
            throw new NotFoundHttpException();
        }

        $submittedHash = $data->getConfirmationHash();
        $originHash = $persistedUser->getConfirmationHash();

        if ($submittedHash !== $originHash) {
            throw new BadRequestHttpException(
                'The submitted hash is not valid.',
            );
        }

        $persistedUser
            ->setConfirmedAt(new DateTimeImmutable())
            ->setIsConfirmed(true)
            ->setConfirmationHash(null);

        $this->entityManager->persist($persistedUser);
        $this->entityManager->flush();

        return $persistedUser;
    }
}
