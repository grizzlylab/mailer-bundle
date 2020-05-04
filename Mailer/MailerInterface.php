<?php

namespace Grizzlylab\Bundle\MailerBundle\Mailer;

use Swift_Attachment;
use Twig\Environment;
use Twig\TemplateWrapper;

/**
 * @author Jean-Louis Pirson <jeanlouis@myqm.io>
 */
interface MailerInterface
{
    /**
     * Send email message.
     *
     * If the content is a template and if the subject is null,
     * we use the first line of the template as the subject && the rest as the body
     *
     * @param string|TemplateWrapper $content   text or the template name
     * @param array|string           $addresses an array (multiple recipients) or a string (single recipient)
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
    ): int;

    public function getSender(): array;

    public function setTwig(Environment $twig);
}
