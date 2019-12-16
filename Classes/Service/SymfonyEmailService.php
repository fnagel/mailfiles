<?php

namespace FelixNagel\Mailfiles\Service;

/**
 * This file is part of the "mailfiles" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Symfony\Component\Mime\Address;
use TYPO3\CMS\Core\Mail\MailMessage;

/**
 * Handles email sending and templating.
 */
class SymfonyEmailService extends BaseEmailService
{
    /**
     * This is the main-function for sending Mails.
     *
     * @param MailMessage $message
     * @param array $mailTo
     * @param array $mailFrom
     * @param string $subject
     * @param string $emailBody
     *
     * @return MailMessage
     */
    public function populateMailMessage(MailMessage $message, $mailTo, $mailFrom, $subject, $emailBody)
    {
        $message
            ->subject($subject)
            ->to(new Address(key($mailTo), current($mailTo) || ''))
            ->from(new Address(key($mailFrom), current($mailFrom) || ''));

        if (strip_tags($emailBody) == $emailBody) {
            $message->text($emailBody, $GLOBALS['TSFE']->metaCharset);
        } else {
            $message->html($emailBody, $GLOBALS['TSFE']->metaCharset);
        }

        return $message;
    }
}
