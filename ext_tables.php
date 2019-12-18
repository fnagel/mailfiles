<?php

defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function () {
        /* @var $iconRegistry \TYPO3\CMS\Core\Imaging\IconRegistry */
        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
            \TYPO3\CMS\Core\Imaging\IconRegistry::class
        );
        $iconRegistry->registerIcon(
            'extensions-mailfiles-wizard',
            \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
            ['source' => 'EXT:mailfiles/Resources/Public/Icons/Extension.png']
        );
    }
);
