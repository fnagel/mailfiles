<?php

namespace FelixNagel\Mailfiles\Domain\Model;

/***
 *
 * This file is part of the "mailesfiles2" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * (c) 2011-2018 Felix Nagel <info@felixnagel.com>
 *
 ***/

/**
 * Mail.
 */
class Mail extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
    /**
     * subject.
     *
     * @var string
     * @validate Text
     */
    protected $subject = '';

    /**
     * message.
     *
     * @var string
     * @validate Text
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
