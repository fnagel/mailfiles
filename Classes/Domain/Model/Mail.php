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

/**
 * Mail.
 */
class Mail extends AbstractEntity
{
    /**
     * subject.
     *
     * @var string
     */
    #[Extbase\Validate(['validator' => 'Text'])]
    protected string $subject = '';

    /**
     * message.
     *
     * @var string
     */
    #[Extbase\Validate(['validator' => 'Text'])]
    protected string $message = '';

    /**
     * Returns the subject.
     *
     * @return string $subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Sets the subject.
     *
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Returns the message.
     *
     * @return string $message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Sets the message.
     *
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}
