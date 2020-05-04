<?php

namespace Grizzlylab\Bundle\MailerBundle\Mailer;

use Swift_Attachment;
use Swift_Mailer;
use Twig\Environment;

/**
 * @author Jean-Louis Pirson <jl.pirson@grizzlylab.be>
 */
class Mailer implements MailerInterface
{
    protected Swift_Mailer $mailer;
    protected array $sender;
    protected ?Environment $twig = null;

    public function __construct(
        Swift_Mailer $mailer,
        ?Environment $twig,
        array $sender
    ) {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->sender = $sender;
    }

    public function send(
        $content,
        $addresses,
        ?string $subject = null,
        array $templateParameters = [],
        bool $contentIsATemplate = true,
        ?array $sender = null,
        ?Swift_Attachment $attachment = null,
        string $contentType = 'text/html',
        ?string $charset = null
    ): int {
        if ($contentIsATemplate) {
            // Render the email, use the first line as the subject, && the rest as the body
            $renderedLines = explode("\n", trim($this->twig->render($content, $templateParameters)));

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
        if (null === $sender) {
            $sender = $this->sender;
        }

        if (null !== $attachment) {
            $message->attach($attachment);
        }

        $message->setFrom($sender['address'], $sender['name']);

        return $this->mailer->send($message);
    }

    public function getSender(): array
    {
        return $this->sender;
    }

    public function setTwig(Environment $twig): void
    {
        $this->twig = $twig;
    }
}
