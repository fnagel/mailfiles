<?php

namespace FelixNagel\Mailfiles\Service;

/**
 * This file is part of the "mailfiles" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Symfony\Component\Mime\Email;
use TYPO3\CMS\Core\Mail\FluidEmail;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\TemplatePaths;

/**
 * Handles email sending and templating using TYPO3's Fluid email functionality.
 */
class FluidEmailService extends BaseEmailService
{
    protected function send(Email $message, array $variables, string $templateFile): bool
    {
        /*  @var FluidEmail $message */
        $message
            ->assignMultiple($this->getDefaultTemplateVariables())
            ->assignMultiple($variables)
            ->setTemplate(pathinfo($templateFile, PATHINFO_BASENAME));

        $format = pathinfo($templateFile, PATHINFO_EXTENSION);
        $message->format($format === 'txt' ? FluidEmail::FORMAT_PLAIN : FluidEmail::FORMAT_HTML);

        $this->mailer->send($message);

        return $this->mailer->getSentMessage() !== null;
    }

    /**
     * Returns an instance of TemplatePaths with paths configured in TypoScript and
     * paths configured in $GLOBALS['TYPO3_CONF_VARS']['MAIL'].
     *
     * Taken from EXT:fe_login.
     */
    protected function getMailTemplatePaths(): TemplatePaths
    {
        $frameworkConfig = $this->getFrameworkConfiguration();
        $templateRootPaths = [];

        foreach ($frameworkConfig['view']['templateRootPaths'] as $key => $templateRootPath) {
            $templateRootPaths[$key] = $templateRootPath.self::TEMPLATE_FOLDER.'/';
        }

        $templatePaths = new TemplatePaths();
        $templatePaths->setTemplateRootPaths(array_replace(
            $GLOBALS['TYPO3_CONF_VARS']['MAIL']['templateRootPaths'] ?? [],
            $templateRootPaths,
        ));
        $templatePaths->setLayoutRootPaths(array_replace(
            $GLOBALS['TYPO3_CONF_VARS']['MAIL']['layoutRootPaths'] ?? [],
            $frameworkConfig['view']['layoutRootPaths'] ?? [],
        ));
        $templatePaths->setPartialRootPaths(array_replace(
            $GLOBALS['TYPO3_CONF_VARS']['MAIL']['partialRootPaths'] ?? [],
                $frameworkConfig['view']['partialRootPaths'] ?? [],
        ));

        return $templatePaths;
    }

    protected function createMailMessage(): Email
    {
        return GeneralUtility::makeInstance(FluidEmail::class, $this->getMailTemplatePaths());
    }
}
