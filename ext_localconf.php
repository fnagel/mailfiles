<?php

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function () {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'TYPO3.Mailfiles',
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
