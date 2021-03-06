<?php

namespace FelixNagel\Mailfiles\Domain\Model;

/**
 * This file is part of the "mailfiles" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Extbase\Annotation as Extbase;

/**
 * Mail.
 */
class Mail extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * subject.
     *
     * @var string
     * @Extbase\Validate("Text")
     */
    protected $subject = '';

    /**
     * message.
     *
     * @var string
     * @Extbase\Validate("Text")
     */
    protected $message = '';

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
