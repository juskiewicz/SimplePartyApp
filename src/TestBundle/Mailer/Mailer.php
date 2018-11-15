<?php

namespace TestBundle\Mailer;

use TestBundle\Entity\Party;

class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var string
     */
    private $mailTo;

    /**
     * @var string
     */
    private $mailFrom;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig, string $mailFrom, string $mailTo) {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->mailFrom = $mailFrom;
        $this->mailTo = $mailTo;
    }

    public function sendPartyAddedEmail(Party $party)
    {
        $body = $this->twig->render(
            'TestBundle:Email:added.html.twig',
            [
                'party' => $party
            ]
        );

        $message =
            (new \Swift_Message())->setSubject('New party added!')
                ->setFrom($this->mailFrom)
                ->setTo($this->mailTo)
                ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }
}