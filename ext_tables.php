<?php

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Imaging\IconRegistry;
use TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider;

defined('TYPO3') || die('Access denied.');

call_user_func(
    static function () {
        $iconRegistry = GeneralUtility::makeInstance(IconRegistry::class);
        $iconRegistry->registerIcon(
            'extensions-mailfiles-wizard',
            BitmapIconProvider::class,
            ['source' => 'EXT:mailfiles/Resources/Public/Icons/Extension.png']
        );
    }
);
