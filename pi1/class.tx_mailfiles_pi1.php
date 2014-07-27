<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011-2014 Felix Nagel <info@felixnagel.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/


/**
 * Plugin 'Mail File' for the 'mailfiles' extension.
 *
 * @author    Felix Nagel <info@felixnagel.com>
 * @package    TYPO3
 * @subpackage    tx_mailfiles
 */
class tx_mailfiles_pi1 extends tslib_pibase {

	var $prefixId = 'tx_mailfiles_pi1';
	var $scriptRelPath = 'pi1/class.tx_mailfiles_pi1.php';
	var $extKey = 'mailfiles';
	var $pi_checkCHash = TRUE;

	/*
	 * @param tx_pluploadfe_pi1
	 */
	private $pluploadfe = NULL;

	/**
	 * The main method of the PlugIn
	 *
	 * @param    string $content : The PlugIn content
	 * @param    array $conf : The PlugIn configuration
	 * @return    string        The content that is displayed on the website
	 */
	public function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();

		if (!t3lib_extMgm::isLoaded('pluploadfe')) {
			return '<div style="border: 3px solid red; padding: 1em;">' .
			'<strong>TYPO3 EXT:mailfiles Error</strong><br />EXT:pluploadfe not installed</div>';
		}

		// form sent?
		$postVariables = t3lib_div::_GP('mailfiles');
		if ($postVariables['submit']) {
			$files = $GLOBALS['TSFE']->fe_user->getKey('ses', 'tx_pluploadfe_files');
			if (is_array($files) && count($files) > 0) {
				$msg = t3lib_div::removeXSS(strip_tags($postVariables['message']));
				$content = $this->sendMail($files, $msg);
			} else {
				$content = $this->cObj->cObjGetSingle($this->conf['no_files'], $this->conf['no_files.']);
			}
		} else {
			$content .= $this->renderPlupload($content);
			$content .= $this->cObj->cObjGetSingle($this->conf['form'], $this->conf['form.']);
		}

		return $this->pi_wrapInBaseClass($content);
	}

	public function sendMail($files, $msg) {
		$bodyHtml = '';

		// add text
		$bodyHtml .= $this->cObj->cObjGetSingle($this->conf['mail.']['beforeMessage'], $this->conf['mail.']['beforeMessage.']);
		$bodyHtml .= nl2br($msg);
		$bodyHtml .= $this->cObj->cObjGetSingle($this->conf['mail.']['afterMessage'], $this->conf['mail.']['afterMessage.']);

		// add files
		foreach ($files as $file) {
			$bodyHtml .= '<a href="' . $file . '">' . $file . '</a><br />';
		}

		// plain text only
		$bodyText = preg_replace('!<br.*>!iU', LF, $bodyHtml);
		$bodyText = t3lib_div::substUrlsInPlainText(strip_tags($bodyHtml));
		// break lines
		$bodyText = wordwrap($bodyText, 76, "\n", FALSE);

		$mail = t3lib_div::makeInstance('t3lib_mail_Message');
		$mail->setFrom(array($this->conf['mail.']['from'] => $this->conf['mail.']['from_name']));
		$mail->setTo($this->conf['mail.']['to']);
		if (strlen($this->conf['mail.']['bbc']) > 0) {
			$mail->setBcc($this->conf['mail.']['bbc']);
		}
		$mail->setSubject($this->conf['mail.']['subject']);
		$mail->setBody($bodyHtml, 'text/html');
		$mail->addPart($bodyText, 'text/plain');
		$mail->send();

		// reset saved files in seesion
		$GLOBALS['TSFE']->fe_user->setKey('ses', 'tx_pluploadfe_files', '');
		$GLOBALS['TSFE']->fe_user->storeSessionData();

		return $this->cObj->cObjGetSingle($this->conf['success'], $this->conf['success.']);
	}

	public function renderPlupload($content) {
		t3lib_div::requireOnce(t3lib_extMgm::extPath('pluploadfe', 'pi1/class.tx_pluploadfe_pi1.php'));
		$this->pluploadfe = t3lib_div::makeInstance('tx_pluploadfe_pi1');
		$this->pluploadfe->cObj = $this->cObj;

		if (!is_numeric($this->conf['configUid'])) {
			$this->conf['configUid'] = intval($this->cObj->data['tx_mailfiles_pluploadfe_config']);
		}

		if ($this->cObj->data['_LOCALIZED_UID']) {
			$this->conf['uid'] = intval($this->cObj->data['_LOCALIZED_UID']);
		} else {
			$this->conf['uid'] = intval($this->cObj->data['uid']);
		}

		return $this->pluploadfe->main($content, $this->conf);
	}
}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mailfiles/pi1/class.tx_mailfiles_pi1.php']) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mailfiles/pi1/class.tx_mailfiles_pi1.php']);
}

?>