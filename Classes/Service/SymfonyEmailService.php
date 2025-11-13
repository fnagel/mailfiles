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
use TYPO3\CMS\Fluid\View\StandaloneView;

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

        $message->send();

        return $message->isSent();
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
    protected function getEmailView(string $templateFile): StandaloneView
    {
        $emailView = $this->createStandaloneView();

        $format = pathinfo($templateFile, PATHINFO_EXTENSION);
        $emailView->setFormat($format);
        $emailView->getRenderingContext()->getTemplatePaths()->setFormat($format);

        $emailView->getRenderingContext()->setControllerName(self::TEMPLATE_FOLDER);
        $emailView->getRenderingContext()->setControllerAction($templateFile);

        return $emailView;
    }

    protected function createStandaloneView(): StandaloneView
    {
        /* @var $emailView StandaloneView */
        $emailView = GeneralUtility::makeInstance(StandaloneView::class);

        $this->setViewPaths($emailView);

        return $emailView;
    }

    protected function setViewPaths(StandaloneView $emailView): void
    {
        $frameworkConfig = $this->getFrameworkConfiguration();

        if (isset($frameworkConfig['view']['layoutRootPaths'])) {
            $emailView->getRenderingContext()->getTemplatePaths()->setLayoutRootPaths($frameworkConfig['view']['layoutRootPaths']);
        }

        if (isset($frameworkConfig['view']['partialRootPaths'])) {
            $emailView->getRenderingContext()->getTemplatePaths()->setPartialRootPaths($frameworkConfig['view']['partialRootPaths']);
        }

        if (isset($frameworkConfig['view']['templateRootPaths'])) {
            $emailView->getRenderingContext()->getTemplatePaths()->setTemplateRootPaths($frameworkConfig['view']['templateRootPaths']);
        }
    }
}
