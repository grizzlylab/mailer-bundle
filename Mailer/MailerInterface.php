<?php

namespace GrizzlyLab\Bundle\MailerBundle\Mailer;

/**
 * interface MailerInterface
 * @author Jean-Louis Pirson <jl.pirson@grizzlylab.be>
 */
interface MailerInterface
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
