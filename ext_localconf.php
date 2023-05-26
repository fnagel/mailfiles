<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use FelixNagel\Mailfiles\Controller\DefaultController;

defined('TYPO3') || die('Access denied.');

call_user_func(
    static function () {
        // Add page TS config
        ExtensionManagementUtility::addPageTSConfig(
            '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:mailfiles/Configuration/TSconfig/page.tsconfig">'
        );

        // Configure plugin
        ExtensionUtility::configurePlugin(
            'Mailfiles',
            'Pi1',
            [
                DefaultController::class => 'new, create',
            ],
            // non-cacheable actions
            [
                DefaultController::class => 'new, create',
            ]
        );
    }
);
