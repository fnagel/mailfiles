<?php

namespace FelixNagel\Mailfiles\Controller;

/**
 * This file is part of the "mailfiles" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use FelixNagel\Pluploadfe\Middleware\Upload;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity as Message;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use FelixNagel\Mailfiles\Service\SymfonyEmailService;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use FelixNagel\Mailfiles\Domain\Model\Mail;

class DefaultController extends ActionController
{
    protected ?int $configUid = null;

    protected function initializeAction()
    {
        if (!ExtensionManagementUtility::isLoaded('pluploadfe')) {
            throw new \Exception('EXT:pluploadfe is not installed!');
        }

        if (empty($this->settings['mailTo']['email'])) {
            throw new \Exception('No mail to address given!');
        }

        // @extensionScannerIgnoreLine
        $contentObject = $this->configurationManager->getContentObject();
        $this->configUid = (int) $contentObject->data['tx_mailfiles_pluploadfe_config'];

        if (empty($this->configUid)) {
            throw new \Exception('No config UID given!');
        }
    }

    public function newAction(): ResponseInterface
    {
        // @extensionScannerIgnoreLine
        $contentObject = $this->configurationManager->getContentObject();

        $this->view->assignMultiple([
            'configUid' => (int) $contentObject->data['tx_mailfiles_pluploadfe_config']
        ]);

        return $this->htmlResponse();
    }

    public function createAction(Mail $newMail): ResponseInterface
    {
        $files = $this->getFilesInSession();

        if ($files === null) {
            $this->addFlashMessage($this->translate('flashMessage.noFiles'), '', Message::ERROR);
            return $this->errorAction();
        }

        $result = $this->sendEmail($newMail, $files);

        if ($result) {
            $this->addFlashMessage($this->translate('flashMessage.success'));
        } else {
            $this->addFlashMessage($this->translate('flashMessage.error'), '', Message::ERROR);
        }

        $this->resetFilesInSession();

        return $this->redirect('new');
    }

    protected function sendEmail(Mail $mail, array $files = []): bool
    {
        // See 2.1.1. Line Length Limits, http://www.faqs.org/rfcs/rfc2822.html
        $subject = substr(htmlspecialchars(strip_tags($mail->getSubject())), 0, 78);

        // String will be escaped by Fluid, but we don't want tags anyway
        $message = strip_tags($mail->getMessage());

        $mailTo = $this->settings['mailTo'];
        $mailFrom = $this->settings['mailFrom'];

		$emailService = GeneralUtility::makeInstance(SymfonyEmailService::class);

        return $emailService->sendEmail(
            [$mailTo['email'] => empty($mailTo['name']) ? null : $mailTo['name']],
            [$mailFrom['email'] => empty($mailFrom['name']) ? null : $mailFrom['name']],
            empty($subject) ? $this->settings['mailSubjectDefault'] : $subject,
            [
                'message' => $message,
                'files' => $files,
            ],
            $this->settings['mailTemplate']
        );
    }

    protected function getFilesInSession(): ?array
    {
        $files = $this->getTsFeController()->fe_user->getKey('ses', $this->getSessionName());

        return (!is_array($files) || $files === []) ? null : $files;
    }

    protected function resetFilesInSession(): void
    {
        $this->getTsFeController()->fe_user->setKey('ses', $this->getSessionName(), '');
        // @extensionScannerIgnoreLine
        $this->getTsFeController()->fe_user->storeSessionData();
    }

    protected function getSessionName(): string
    {
        return Upload::SESSION_KEY_PREFIX.$this->configUid.'_files';
    }

    protected function translate(string $key): ?string
    {
        $translation = LocalizationUtility::translate($key, $this->request->getControllerExtensionName());

        return empty($translation) ? $key : $translation;
    }

    protected function getTsFeController(): TypoScriptFrontendController
    {
        return $GLOBALS['TSFE'];
    }

    protected function getErrorFlashMessage()
    {
        return false;
    }
}
