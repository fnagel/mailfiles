<?php

namespace FelixNagel\Mailfiles\Service;

/**
 * This file is part of the "mailfiles" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MailUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/**
 * Handles email sending and templating.
 */
abstract class BaseEmailService implements SingletonInterface
{
    /**
     * @var string
     */
    protected const TEMPLATE_FOLDER = 'Email';

    protected string $extensionName = 'Mailfiles';

    protected string $pluginName = 'Pi1';

    public ?ConfigurationManagerInterface $configurationManager = null;

    public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager): void
    {
        $this->configurationManager = $configurationManager;
    }

    protected function getFrameworkConfiguration(): array
    {
        return $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
            $this->extensionName,
            $this->pluginName
        );
    }

    /**
     * This is the main-function for sending Mails.
     *
     * @return bool Checks whether the message has been sent
     */
    public function sendEmail(array $mailTo, array $mailFrom, string $subject, array $variables, string $templateFile): bool
    {
        if (!GeneralUtility::validEmail(key($mailTo))) {
            return 0;
        }

        if (!GeneralUtility::validEmail(key($mailFrom))) {
            $mailFrom = MailUtility::getSystemFrom();
        }

        $message = $this->createMailMessage()
            ->subject($subject)
            ->to(new Address(key($mailTo), current($mailTo) || ''))
            ->from(new Address(key($mailFrom), current($mailFrom) || ''));

		// @extensionScannerIgnoreLine
        return $this->send($message, $variables, $templateFile);
    }

    protected function getDefaultTemplateVariables(): array
    {
        return [
            'timestamp' => GeneralUtility::makeInstance(Context::class)->getPropertyFromAspect('date', 'timestamp'),
            'domain' => GeneralUtility::getIndpEnv('TYPO3_SITE_URL'),
        ];
    }

    abstract protected function send(Email $message, array $variables, string $templateFile): bool;

    abstract protected function createMailMessage(): Email;
}
