<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::addStaticFile($_EXTKEY, 'pi1/static/', 'Mail Files: default config');
t3lib_extMgm::addStaticFile($_EXTKEY, 'pi1/static/old/', 'Mail Files: old form config');
t3lib_extMgm::addStaticFile($_EXTKEY, 'pi1/static/new/', 'Mail Files: new form config for EXT:form');

$tempColumns = array(
	'tx_mailfiles_pluploadfe_config' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:pluploadfe/locallang_db.xml:tt_content.tx_pluploadfe_config',
		'config' => array(
			'type' => 'group',
			'internal_type' => 'db',
			'allowed' => 'tx_pluploadfe_config',
			'foreign_table' => 'tx_pluploadfe_config',
			'size' => 1,
			'minitems' => 1,
			'maxitems' => 1,
			'wizards' => array(
				'suggest' => array(
					'type' => 'suggest',
				),
			),
		),
	),
);


t3lib_div::loadTCA('tt_content');
t3lib_extMgm::addTCAcolumns('tt_content', $tempColumns, 1);
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_pi1'] = 'tx_mailfiles_pluploadfe_config';
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY . '_pi1'] = 'layout,select_key,pages';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:mailfiles/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
), 'list_type');


if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_mailfiles_pi1_wizicon'] =
		t3lib_extMgm::extPath($_EXTKEY) . 'pi1/class.tx_mailfiles_pi1_wizicon.php';
}
?>