<?php

namespace Grizzlylab\Bundle\MailerBundle\Service;

/**
 * interface MailerInterface
 * @author Jean-Louis Pirson <jl.pirson@grizzlylab.be>
 */
interface MailerServiceInterface
{
    /**
     * Send an email
     *
     * @param string     $renderedTemplate
     * @param string     $toEmail
     * @param array|null $sender
     *
     * @return void
     */
    public function send($renderedTemplate, $toEmail, array $sender = null);
}
