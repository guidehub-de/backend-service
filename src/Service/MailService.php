<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailService
{
    public function __construct(
        private readonly MailerInterface $mailer,
    ) {
    }

    public function sentEmail(
        string $subject,
        string $sender,
        string $recipient,
        string $message,
        string $template = 'mail.html.twig',
    ): void {
        $email = (new TemplatedEmail())
        ->from($sender)
        ->to($recipient)
        ->subject($subject)
        ->htmlTemplate(\sprintf('emails/%s', $template))
        ->context([
            'message' => $message,
        ]);

        $this->mailer->send($email);
    }
}
