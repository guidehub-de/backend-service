<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Entity\User;
use App\Message\SendConfirmationEmailMessage;
use App\Repository\UserRepository;
use App\Service\MailService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\Translation\TranslatorInterface;

#[AsMessageHandler]
final class SendConfirmationEmailMessageHandler
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly MailService $mailService,
        private readonly TranslatorInterface $translator,
        private readonly string $frontendUrl,
    ) {
    }

    public function __invoke(SendConfirmationEmailMessage $message): void
    {
        $user = $this->userRepository->find($message->getUserId());

        if (!$user instanceof User) {
            return;
        }

        $confirmationUrl = \sprintf(
            '%s/registration/confirm/%s',
            $this->frontendUrl,
            $user->getConfirmationHash(),
        );

        $this->mailService->sentEmail(
            $this->translator->trans('confirmation.email.subject', [], 'registration', $user->getLocale()),
            'test@guidehub.tld',
            $user->getEmail(),
            $this->translator->trans('confirmation.email.message', [
                '%confirmation_url%' => $confirmationUrl,
            ], 'registration', $user->getLocale()),
        );
    }
}
