<?php

namespace Grizzlylab\Bundle\MailerBundle\Service;

use Swift_Attachment;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * class MailerService.
 *
 * @author Jean-Louis Pirson <jl.pirson@grizzlylab.be>
 */
class MailerService implements MailerServiceInterface
{
    protected $mailer;
    protected $sender;
    protected $templating;

    /**
     * MailerService constructor.
     *
     * @param Swift_Mailer         $mailer
     * @param EngineInterface|null $templating if null, it must be set with the setter method "setTemplating"
     * @param array                $sender
     */
    public function __construct(
        Swift_Mailer $mailer,
        ?EngineInterface $templating,
        array $sender
    ) {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->sender = $sender;
    }

    /**
     * {@inheritdoc}
     */
    public function send(
        $content,
        $addresses,
        ?string $subject = null,
        array $templateParameters = [],
        bool $contentIsATemplate = true,
        ?array $sender = null,
        Swift_Attachment $attachment = null,
        string $contentType = 'text/html',
        ?string $charset = null
    ) {
        if ($contentIsATemplate) {
            // Render the email, use the first line as the subject, && the rest as the body
            $renderedLines = explode("\n", trim($this->templating->render($content, $templateParameters)));

            if (null === $subject) {
                $subject = $renderedLines[0];
            }
            $body = implode("\n", array_slice($renderedLines, 1));
        } else {
            $body = $content;
        }

        /** @var \Swift_Message $message */
        $message = $this->mailer->createMessage()
            ->setSubject($subject)
            ->setTo($addresses)
            ->setBody($body, $contentType, $charset)
        ;

        // Default sender
        if (null == $sender) {
            $sender = $this->sender;
        }

        if (!empty($attachment)) {
            $message->attach($attachment);
        }

        $message->setFrom($sender['address'], $sender['name']);

        return $this->mailer->send($message);
    }

    /**
     * {@inheritdoc}
     */
    public function getSender(): array
    {
        return $this->getSender();
    }

    /**
     * {@inheritdoc}
     */
    public function setTemplating(EngineInterface $templating)
    {
        $this->templating = $templating;
    }
}
