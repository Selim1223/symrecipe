<?php 

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailService
{
    /**
     * Undocumented variable
     *
     * @var MailerInterface
     */
    private MailerInterface $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(string $form,
    string $subject,
    string $htmlTemplate,
    array $context,
    string $to ='admin@symrepice.com'
    ): void
    {
        $email = (new TemplatedEmail())
        ->from($form)
        ->to($to)
        ->subject($subject)
        ->htmlTemplate($htmlTemplate)
        ->context($context);

        $this->mailer->send($email);
    }
}