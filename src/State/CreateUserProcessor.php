<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/** @implements ProcessorInterface<User, User> */
class CreateUserProcessor implements ProcessorInterface
{
    /** @param ProcessorInterface<User, User> $processor */
    public function __construct(
        private readonly ProcessorInterface $processor,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly RequestStack $requestStack,
    ) {
    }

    /** @param User $data */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): User
    {
        if (null === $data->getPlainPassword()) {
            throw new BadRequestHttpException(
                'Password must not be null.',
            );
        }

        $hashedPassword = $this->passwordHasher->hashPassword(
            $data,
            $data->getPlainPassword(),
        );

        $confirmationHash = \hash('sha256', \uniqid() . $data->getEmail());

        /** @var string $locale */
        $locale = $this->requestStack->getCurrentRequest()?->getLocale();

        $data
            ->setLocale($locale)
            ->setIsConfirmed(false)
            ->setConfirmationHash($confirmationHash)
            ->setPassword($hashedPassword)
            ->eraseCredentials();

        return $this->processor->process($data, $operation, $uriVariables, $context);
    }
}
