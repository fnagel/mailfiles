<?php

defined('TYPO3') || die('Access denied.');

call_user_func(
    function () {
        // Add page TS config
        TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:mailfiles/Configuration/TSconfig/page.tsconfig">'
        );

        // Configure plugin
        TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'Mailfiles',
            'Pi1',
            [
                FelixNagel\Mailfiles\Controller\DefaultController::class => 'new, create',
            ],
            // non-cacheable actions
            [
                FelixNagel\Mailfiles\Controller\DefaultController::class => 'new, create',
            ]
        );
    }
);
