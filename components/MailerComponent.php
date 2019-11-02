<?php
namespace app\components;

use Yii;
use yii\base\Component;

class MailerComponent extends Component
{
    public function send(string $recipient, string $subject, string $body)
    {
        $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
            ->setUsername(getenv('MAIL_USERNAME'))
            ->setPassword(getenv('MAIL_PASSWORD'));
        $mailer = new \Swift_Mailer($transport);
        $message = (new \Swift_Message('Email Through Swift Mailer'))
            ->setFrom(['no-reply@fotokolo.space' => 'no-reply@fotokolo.space'])
            ->setTo([$recipient])
            ->setSubject($subject)
            ->setBody($body)
            ->setContentType('text/html');
        $mailer->send($message);
    }
}