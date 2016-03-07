<?php

namespace Aculyse\Mail;

use Swift_SmtpTransport;
use Aculyse\Config;
require_once dirname(dirname(__DIR__)) ."/logic/config/mail.php";
require_once dirname(dirname(dirname(__DIR__))) . "/vendor/autoload.php";

class Mail
{
    public $recipient;
    public $message;
    public $heading;

    function send()
    {

        return mail($this->recipient,$this->heading,$this->message);


        $transport = Swift_SmtpTransport::newInstance(MAIL_HOST, 25)
            ->setUsername(MAIL_USER)
            ->setPassword(MAIL_PASSWORD);

        // Create the Mailer using your created Transport
        $mailer = Swift_Mailer::newInstance($transport);

        // Create a message
        $message = Swift_Message::newInstance($this->heading)
            ->setFrom(array(MAIL_SENDER => 'Aculyse'))
            ->setTo($this->recipient)
            ->setBody($this->message);

        // Send the message
        $result = $mailer->send($message);

       return $result;
    }
}