<?php

namespace GrizzlyLab\Bundle\MailerBundle\Mailer;

use Swift_Mailer;

/**
 * Mailer
 * @author Jean-Louis Pirson <jl.pirson@grizzlylab.be>
 */
class Mailer implements MailerInterface
{
    /**
     * @var Swift_Mailer
     */
    protected $mailer;

    /**
     * @var array
     */
    protected $sender;

    /**
     * Constructor
     *
     * @param Swift_Mailer $mailer
     * @param array        $sender
     */
    public function __construct(Swift_Mailer $mailer, $sender)
    {
        $this->mailer = $mailer;
        $this->sender = $sender;
    }

    /**
     * Send email message
     *
     * @param string     $renderedTemplate
     * @param string     $toEmail
     * @param array|null $sender
     */
    public function send($renderedTemplate, $toEmail, array $sender = null)
    {

        // Render the email, use the first line as the subject, && the rest as the body
        $renderedLines = explode("\n", trim($renderedTemplate));
        $subject = $renderedLines[0];
        $body = implode("\n", array_slice($renderedLines, 1));

        /**
         * @var \Swift_Message $message
         */
        $message = $this->mailer->createMessage()
            ->setSubject($subject)
            ->setTo($toEmail)
            ->setBody($body);

        // Default sender
        if ($sender == null) {
            $sender = $this->sender;
        }

        $message->setFrom($sender['address'], $sender['name']);

        $this->mailer->send($message);
    }
}