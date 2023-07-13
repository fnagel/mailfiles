<?php

namespace FelixNagel\Mailfiles\Service;

/**
 * This file is part of the "mailfiles" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MailUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Core\Context\Context;

/**
 * Handles email sending and templating.
 */
abstract class BaseEmailService implements SingletonInterface
{
    /**
     * @var string
     */
    public const TEMPLATE_FOLDER = 'Email';

    protected string $extensionName = 'mailfiles';

    public ?ConfigurationManagerInterface $configurationManager = null;

    public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager): void
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * This is the main-function for sending Mails.
     *
     * @return int The number of recipients who were accepted for delivery
     */
    public function sendEmail(array $mailTo, array $mailFrom, string $subject, array $variables, string $templatePath): int
    {
		// @extensionScannerIgnoreLine
        return $this->send($mailTo, $mailFrom, $subject, $this->render($variables, $templatePath));
    }

    /**
     * This is the main-function for sending Mails.
     *
     * @return int The number of recipients who were accepted for delivery
     */
    protected function send(array $mailTo, array $mailFrom, string $subject, string $emailBody): int
    {
        if (!($mailTo && is_array($mailTo) && GeneralUtility::validEmail(key($mailTo)))) {
            return false;
        }

        if (!($mailFrom && is_array($mailFrom) && GeneralUtility::validEmail(key($mailFrom)))) {
            $mailFrom = MailUtility::getSystemFrom();
        }

        $message = $this->populateMailMessage(
            $this->createMailMessage(),
            $mailTo,
            $mailFrom,
            $subject,
            $emailBody
        );

        $message->send();

        return $message->isSent();
    }

    /**
     * This functions renders template to use in Mails and Other views.
     */
    protected function render(array $variables, string $templatePath): string
    {
        $emailView = $this->getEmailView($templatePath);
        $emailView->assignMultiple($variables);
        $emailView->assignMultiple([
            'timestamp' => GeneralUtility::makeInstance(Context::class)->getPropertyFromAspect('date', 'timestamp'),
            'domain' => GeneralUtility::getIndpEnv('TYPO3_SITE_URL'),
        ]);

        return $emailView->render();
    }

    /**
     * Create and configure the view.
     */
    protected function getEmailView(string $templateFile): StandaloneView
    {
        $emailView = $this->createStandaloneView();

        $format = pathinfo($templateFile, PATHINFO_EXTENSION);
        $emailView->setFormat($format);
        $emailView->getTemplatePaths()->setFormat($format);

        $emailView->getRenderingContext()->setControllerName(self::TEMPLATE_FOLDER);
        $emailView->setTemplate($templateFile);

        return $emailView;
    }

    protected function createStandaloneView(): StandaloneView
    {
        /* @var $emailView StandaloneView */
        $emailView = GeneralUtility::makeInstance(StandaloneView::class);

        $this->setViewPaths($emailView);

        return $emailView;
    }

    protected function setViewPaths(StandaloneView $emailView)
    {
        $frameworkConfig = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
            $this->extensionName,
            ''
        );

        if (isset($frameworkConfig['view']['layoutRootPaths'])) {
            $emailView->setLayoutRootPaths($frameworkConfig['view']['layoutRootPaths']);
        }

        if (isset($frameworkConfig['view']['partialRootPaths'])) {
            $emailView->setPartialRootPaths($frameworkConfig['view']['partialRootPaths']);
        }

        if (isset($frameworkConfig['view']['templateRootPaths'])) {
            $emailView->setTemplateRootPaths($frameworkConfig['view']['templateRootPaths']);
        }
    }

    /**
     * This is the main-function for sending Mails.
     */
    abstract protected function populateMailMessage(
        MailMessage $message,
        array $mailTo,
        array $mailFrom,
        string $subject,
        string $emailBody
    ): MailMessage;

    protected function createMailMessage(): MailMessage
    {
        return GeneralUtility::makeInstance(MailMessage::class);
    }
}
