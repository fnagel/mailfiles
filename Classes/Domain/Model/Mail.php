<?php

namespace FelixNagel\Mailfiles\Domain\Model;

/**
 * This file is part of the "mailfiles" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class Mail extends AbstractEntity
{
    #[Extbase\Validate(['validator' => 'Text'])]
    protected string $subject = '';

    #[Extbase\Validate(['validator' => 'Text'])]
    protected string $message = '';

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;
    }
}
