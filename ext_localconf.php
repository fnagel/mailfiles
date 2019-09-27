<?php

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function () {
        // Add page TS config
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:'.'mailfiles'.'/Configuration/TypoScript/pageTsConfig.ts">'
        );

        // Configure plugin
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'FelixNagel.Mailfiles',
            'Pi1',
            [
                'Default' => 'new, create',
            ],
            // non-cacheable actions
            [
                'Default' => 'new, create',
            ]
        );
    }
);
