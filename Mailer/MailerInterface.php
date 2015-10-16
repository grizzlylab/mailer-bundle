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
     * @param string $renderedTemplate
     * @param string $fromEmail
     * @param string $toEmail
     *
     * @return void
     */
    public function send($renderedTemplate, $fromEmail, $toEmail);

}