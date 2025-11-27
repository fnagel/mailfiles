<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') || die('Access denied.');

call_user_func(static function() {
    // Add plugin
    $contentTypeName = ExtensionUtility::registerPlugin(
        'Mailfiles',
        'Pi1',
        'LLL:EXT:mailfiles/Resources/Private/Language/locallang_db.xlf:wizard.title',
        'extensions-mailfiles-wizard',
        'plugins',
        'LLL:EXT:mailfiles/Resources/Private/Language/locallang_db.xlf:wizard.description'
    );

    // Add fields to tt_content
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
    ExtensionManagementUtility::addToAllTCAtypes(
        'tt_content',
        '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:plugin,
            tx_mailfiles_pluploadfe_config',
        $contentTypeName,
        'after:palette:headers'
    );
});
