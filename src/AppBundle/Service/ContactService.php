<?php

namespace AppBundle\Service;

use AppBundle\Model\Contact;

class ContactService
{
    private $recipient;
    private $mailer;

    public function __construct($recipient, \Swift_Mailer $mailer)
    {
        $this->recipient = $recipient;
        $this->mailer = $mailer;
    }

    public function sendMail(Contact $contact)
    {
        $message = \Swift_Message::newInstance()
            ->setTo('sarah.khalil@sensiolabs.com')
            ->setFrom($contact->sender)
            ->setSubject($contact->subject)
            ->setBody($contact->message)
        ;

        $this->mailer->send($message);
    }
}
