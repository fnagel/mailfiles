<?php

namespace FelixNagel\Mailfiles\Service;

/**
 * This file is part of the "mailfiles" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Mail\MailMessage;

/**
 * Handles email sending and templating.
 */
class Typo3EmailService extends BaseEmailService
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
            ->setSubject($subject)
            ->setTo($mailTo)
            ->setFrom($mailFrom);

        if (strip_tags($emailBody) == $emailBody) {
            $message->setBody($emailBody, 'text/plain');
        } else {
            $message->setBody($emailBody, 'text/html');
        }

        return $message;
    }

    /**
     * Create mail message.
     *
     * @return MailMessage
     */
    protected function createMailMessage()
    {
        return $this->objectManager->get(
            MailMessage::class,
            null,
            null,
            null,
            $GLOBALS['TSFE']->metaCharset
        );
    }
}
