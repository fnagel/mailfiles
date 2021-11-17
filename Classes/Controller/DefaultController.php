<?php

namespace FelixNagel\Mailfiles\Controller;

/**
 * This file is part of the "mailfiles" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use FelixNagel\Mailfiles\Service\SymfonyEmailService;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use FelixNagel\Mailfiles\Domain\Model\Mail;

/**
 * DefaultController.
 */
class DefaultController extends ActionController
{
    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    protected function initializeAction()
    {
        if (!ExtensionManagementUtility::isLoaded('pluploadfe')) {
            throw new \Exception('EXT:pluploadfe is not installed!');
        }

        if (empty($this->settings['mailTo']['email'])) {
            throw new \Exception('No mail to address given!');
        }
    }

    /**
     * action new.
     */
    public function newAction()
    {
        $this->view->assignMultiple([
            'plupload' => $this->renderPlupload(),
        ]);
    }

    /**
     * action create.
     */
    public function createAction(Mail $newMail)
    {
        $result = $this->sendEmail(
            // See 2.1.1. Line Length Limits, http://www.faqs.org/rfcs/rfc2822.html
            substr(filter_var(strip_tags($newMail->getSubject()), FILTER_SANITIZE_STRING), 0, 78),
            // String will be escaped by fluid, but we don't want tags anyway
            strip_tags($newMail->getMessage()),
            $this->getFilesInSession()
        );

        if ($result) {
            $this->addFlashMessage($this->translate('flashMessage.success'), '', AbstractMessage::OK);
        } else {
            $this->addFlashMessage($this->translate('flashMessage.error'), '', AbstractMessage::ERROR);
        }

        $this->resetFilesInSession();
        $this->redirect('new');
    }

    /**
     * @param string $subject
     * @param string $message
     * @param array  $files
     *
     * @return bool
     */
    protected function sendEmail($subject, $message, $files = [])
    {
        $mailTo = $this->settings['mailTo'];
        $mailFrom = $this->settings['mailFrom'];

		$emailService = $this->objectManager->get(SymfonyEmailService::class);

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

    /**
     * @return mixed
     */
    protected function renderPlupload()
    {
        // @extensionScannerIgnoreLine
        $contentObject = $this->configurationManager->getContentObject();

        if (!is_numeric($this->settings['pluploadfe']['configUid'])) {
            $this->settings['pluploadfe']['configUid'] = (int) $contentObject->data['tx_mailfiles_pluploadfe_config'];
        }

        return $contentObject->cObjGetSingle(
            $this->settings['pluploadfe']['_typoScriptNodeValue'],
            $this->settings['pluploadfe']
        );
    }

    /**
     * @return array
     */
    protected function getFilesInSession()
    {
        $files = $this->getTsFeController()->fe_user->getKey('ses', 'tx_pluploadfe_files');

        if (!is_array($files) || count($files) < 1) {
            $this->addFlashMessage($this->translate('flashMessage.noFiles'), '', AbstractMessage::ERROR);
            $this->errorAction();
        }

        return $files;
    }

    /**
     */
    protected function resetFilesInSession()
    {
        $this->getTsFeController()->fe_user->setKey('ses', 'tx_pluploadfe_files', '');
        // @extensionScannerIgnoreLine
        $this->getTsFeController()->fe_user->storeSessionData();
    }

    /**
     * @param $key
     *
     * @return null|string
     */
    protected function translate($key)
    {
        $translation = LocalizationUtility::translate($key, $this->request->getControllerExtensionName());

        return empty($translation) ? $key : $translation;
    }

    /**
     * @return \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
     */
    protected function getTsFeController()
    {
        return $GLOBALS['TSFE'];
    }

    /**
     * {@inheritdoc}
     */
    protected function getErrorFlashMessage()
    {
        return false;
    }
}
