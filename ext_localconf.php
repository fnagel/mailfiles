<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;
use FelixNagel\Mailfiles\Controller\DefaultController;

defined('TYPO3') || die('Access denied.');

call_user_func(
    static function () {
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
