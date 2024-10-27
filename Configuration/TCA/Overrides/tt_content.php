<?php

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die('Access denied.');

call_user_func(static function ($packageKey) {
    $extensionName = GeneralUtility::underscoredToLowerCamelCase($packageKey);
    $pluginSignature = strtolower($extensionName).'_pi1';
    $tempColumns = [
        'tx_mailfiles_pluploadfe_config' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:pluploadfe/Resources/Private/Language/locallang_db.xml:tt_content.tx_pluploadfe_config',
            'config' => [
                'type' => 'group',
                'allowed' => 'tx_pluploadfe_config',
                'foreign_table' => 'tx_pluploadfe_config',
                'size' => 1,
                'minitems' => 1,
                'maxitems' => 1,
                'wizards' => [
                    'suggest' => [
                        'type' => 'suggest',
                    ],
                ],
            ],
        ],
    ];

    ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumns);
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'tx_mailfiles_pluploadfe_config';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages,recursive';

    // Add plugin
    ExtensionUtility::registerPlugin(
        'Mailfiles',
        'Pi1',
        'LLL:EXT:mailfiles/Resources/Private/Language/locallang_db.xlf:wizard.title',
        'extensions-mailfiles-wizard',
        'plugins',
        'LLL:EXT:mailfiles/Resources/Private/Language/locallang_db.xlf:wizard.description'
    );
}, 'mailfiles');
