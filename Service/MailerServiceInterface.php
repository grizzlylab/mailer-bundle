<?php

namespace Grizzlylab\Bundle\MailerBundle\Service;

use Swift_Attachment;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Templating\TemplateReferenceInterface;

/**
 * interface MailerInterface.
 *
 * @author Jean-Louis Pirson <jeanlouis@myqm.io>
 */
interface MailerServiceInterface
{
    /**
     * Send email message.
     *
     * If the content is a template and if the subject is null,
     * we use the first line of the template as the subject && the rest as the body
     *
     * @param string|TemplateReferenceInterface $content            a simple string or a template name or a TemplateReferenceInterface instance
     * @param array|string                      $addresses          can be an array (multiple recipients) or a string (single recipient)
     * @param string|null                       $subject            subject of email
     * @param array                             $templateParameters parameters for template (useful only if content is a template and if contentIsAtemplate is set to true)
     * @param bool                              $contentIsATemplate determines if the message is actually a template
     * @param array|null                        $sender             the number of recipients who were accepted for delivery
     * @param \Swift_Attachment                 $attachment
     * @param string                            $contentType
     * @param string|null                       $charset
     *
     * @return int
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
    );

    /**
     * Get sender.
     *
     * @return array
     */
    public function getSender(): array;

    /**
     * Set templating.
     *
     * @param EngineInterface $templating
     */
    public function setTemplating(EngineInterface $templating);
}
