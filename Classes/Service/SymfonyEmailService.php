<?php

namespace FelixNagel\Mailfiles\Service;

/**
 * This file is part of the "mailfiles" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Symfony\Component\Mime\Email;
use TYPO3\CMS\Core\Mail\MailMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\View\ViewFactoryData;
use TYPO3\CMS\Core\View\ViewFactoryInterface;
use TYPO3\CMS\Core\View\ViewInterface;

/**
 * Handles email sending and templating.
 */
class SymfonyEmailService extends BaseEmailService
{
    protected function send(Email $message, array $variables, string $templateFile): bool
    {
        /*  @var MailMessage $message */
        $emailBody = $this->render($variables, $templateFile);

        if (strip_tags($emailBody) === $emailBody) {
            $message->text($emailBody);
        } else {
            $message->html($emailBody);
        }

        $this->mailer->send($message);

        return $this->mailer->getSentMessage() !== null;
    }

    protected function createMailMessage(): Email
    {
        return GeneralUtility::makeInstance(MailMessage::class);
    }

    /**
     * This functions renders template to use in Mails and Other views.
     */
    protected function render(array $variables, string $templateName): string
    {
        $emailView = $this->getEmailView($templateName);
        $emailView
            ->assignMultiple($this->getDefaultTemplateVariables())
            ->assignMultiple($variables);

        return $emailView->render();
    }

    /**
     * Create and configure the view.
     */
    protected function getEmailView(string $templateFile): ViewInterface
    {
        $emailView = $this->createStandaloneView($templateFile);
        $emailView->getRenderingContext()->setControllerName(self::TEMPLATE_FOLDER);
        $emailView->getRenderingContext()->setControllerAction($templateFile);

        return $emailView;
    }

    protected function createStandaloneView(string $templateFile): ViewInterface
    {
        /* @var $viewFactory ViewFactoryInterface */
        $viewFactory = GeneralUtility::makeInstance(ViewFactoryInterface::class);

        $frameworkConfig = $this->getFrameworkConfiguration();
        $viewFactoryData = new ViewFactoryData(
            templateRootPaths: $frameworkConfig['view']['templateRootPaths'] ?? null,
            partialRootPaths: $frameworkConfig['view']['partialRootPaths'] ?? null,
            layoutRootPaths: $frameworkConfig['view']['layoutRootPaths'] ?? null,
            format: pathinfo($templateFile, PATHINFO_EXTENSION),
        );

        return $viewFactory->create($viewFactoryData);
    }
}
