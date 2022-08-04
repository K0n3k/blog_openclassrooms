<?php
namespace App\Services;

use Symfony\Component\Mime\Email; 
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\SendmailTransport;
use Symfony\Component\Mime\Address;

class MyMailer {

    public function __construct(Address $cc, string $subject, string $content)
    {
        $transport = Transport::fromDsn($_ENV['MAILER_DSN']);
        $mailer = new Mailer($transport);
        $mailer->send($this->createEmail($cc, $subject, $content));
        dd($mailer);
    }

    public function createEmail(Address $cc, string $subject, string $content) : email {
        $email = (new Email()) 
        ->from($_ENV['MAIL_FORM'])
        ->to($_ENV['MAIL_TO'])
        ->bcc($cc)
        ->priority(Email::PRIORITY_HIGHEST)
        ->subject($subject)
        ->text($content);

        return $email;
    }

}