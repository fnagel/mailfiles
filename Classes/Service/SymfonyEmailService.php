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
    protected function populateMailMessage(
        MailMessage $message,
        array $mailTo,
        array $mailFrom,
        string $subject,
        string $emailBody
    ): MailMessage
    {
        $message
            ->subject($subject)
            ->to(new Address(key($mailTo), current($mailTo) || ''))
            ->from(new Address(key($mailFrom), current($mailFrom) || ''));

        if (strip_tags($emailBody) === $emailBody) {
            $message->text($emailBody);
        } else {
            $message->html($emailBody);
        }

        return $message;
    }
}
