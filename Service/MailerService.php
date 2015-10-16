<?php

namespace Grizzlylab\Bundle\MailerBundle\Service;

use Swift_Mailer;

/**
 * class MailerService
 * @author Jean-Louis Pirson <jl.pirson@grizzlylab.be>
 */
class MailerService implements MailerServiceInterface
{
    /** @var Swift_Mailer */
    protected $mailer;

    /** @var array */
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
     * Addresses can be an array (multiple recipients) or a string (single recipient)
     * The return value is the number of recipients who were accepted for delivery.
     *
     * @param string       $renderedTemplate
     * @param array|string $addresses
     * @param array|null   $sender
     *
     * @return int
     */
    public function send($renderedTemplate, $addresses, array $sender = null)
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
            ->setTo($addresses)
            ->setBody($body);

        // Default sender
        if ($sender == null) {
            $sender = $this->sender;
        }

        $message->setFrom($sender['address'], $sender['name']);

        return $this->mailer->send($message);
    }
}