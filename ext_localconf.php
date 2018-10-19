<?php

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function () {
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
