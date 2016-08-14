<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

// Add static TS
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    $_EXTKEY, 'Configuration/TypoScript/', 'Mail Files: default config'
);

// Add page TS config
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '<INCLUDE_TYPOSCRIPT: source="FILE:EXT:' . $_EXTKEY . '/Configuration/TypoScript/pageTsConfig.ts">'
);

// Add plugin
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(array(
	'LLL:EXT:mailfiles/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1'
), 'list_type');

// @todo Remove this when 6.2 is no longer relevant
if (version_compare(TYPO3_branch, '7.0', '>=')) {
    /* @var $iconRegistry \TYPO3\CMS\Core\Imaging\IconRegistry */
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon(
        'extensions-mailfiles-wizard',
        \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
        ['source' => 'EXT:mailfiles/pi1/ce_wiz.gif']
    );
}
