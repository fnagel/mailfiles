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
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
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

    /**
     * Extension name.
     */
    protected string $extensionName = 'mailfiles';

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
	public ?ObjectManagerInterface $objectManager = null;

    /**
     * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
	public ?ConfigurationManagerInterface $configurationManager = null;

    /**
     * This is the main-function for sending Mails.
     *
     * @param array  $mailTo
     * @param array  $mailFrom
     * @param string $subject
     * @param array  $variables
     * @param string $templatePath
     *
     * @return int the number of recipients who were accepted for delivery
     */
    public function sendEmail($mailTo, $mailFrom, $subject, $variables, $templatePath)
    {
		// @extensionScannerIgnoreLine
        return $this->send($mailTo, $mailFrom, $subject, $this->render($variables, $templatePath));
    }

    /**
     * This is the main-function for sending Mails.
     *
     * @param array  $mailTo
     * @param array  $mailFrom
     * @param string $subject
     * @param string $emailBody
     *
     * @return int the number of recipients who were accepted for delivery
     */
    protected function send($mailTo, $mailFrom, $subject, $emailBody)
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
     *
     * @param array  $variables    Arguments for template
     * @param string $templatePath Choose a template
     *
     * @return string
     */
    protected function render($variables, $templatePath)
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
     *
     * @param string $templateFile Choose a template
     *
     * @return StandaloneView
     */
    protected function getEmailView($templateFile)
    {
        $emailView = $this->createStandaloneView();

        $format = pathinfo($templateFile, PATHINFO_EXTENSION);
        $emailView->setFormat($format);
        $emailView->getTemplatePaths()->setFormat($format);

        $emailView->getRenderingContext()->setControllerName(self::TEMPLATE_FOLDER);
        $emailView->setTemplate($templateFile);

        return $emailView;
    }

    /**
     * @return StandaloneView
     */
    protected function createStandaloneView()
    {
        /* @var $emailView StandaloneView */
        $emailView = $this->objectManager->get(StandaloneView::class);
        $emailView->getRequest()->setPluginName('');
        $emailView->getRequest()->setControllerExtensionName($this->extensionName);

        $this->setViewPaths($emailView);

        return $emailView;
    }

    /**
     * @param StandaloneView $emailView
     */
    protected function setViewPaths($emailView)
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
     *
     * @param array $mailTo
     * @param array $mailFrom
     * @param string $subject
     * @param string $emailBody
     * @return MailMessage
     */
    abstract protected function populateMailMessage(MailMessage $message, $mailTo, $mailFrom, $subject, $emailBody);

    /**
     * Create mail message.
     *
     * @return MailMessage
     */
    protected function createMailMessage()
    {
        return $this->objectManager->get(MailMessage::class);
    }
}
