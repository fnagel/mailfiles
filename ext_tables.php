<?php

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function () {
        // Add static TS
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
            'mailfiles', 'Configuration/TypoScript/', 'Mail Files: default config'
        );

        // Add page TS config
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:'.'mailfiles'.'/Configuration/TypoScript/pageTsConfig.ts">'
        );

        // Add plugin
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'FelixNagel.Mailfiles',
            'Pi1',
            'LLL:EXT:mailfiles/Resources/Private/Language/locallang_db.xlf:plugin.title'
        );

        /* @var $iconRegistry \TYPO3\CMS\Core\Imaging\IconRegistry */
        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Core\Imaging\IconRegistry::class
        );
        $iconRegistry->registerIcon(
            'extensions-mailfiles-wizard',
            \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
            ['source' => 'EXT:mailfiles/Resources/Public/Icons/plugin.png']
        );
    }
);
