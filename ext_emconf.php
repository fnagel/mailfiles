<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "mailfiles".
 *
 * Auto generated 04-01-2014 00:03
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Mail Files',
	'description' => 'Upload files and send download links via email. Uses plupload. Please see readme file.',
	'category' => 'plugin',
	'author' => 'Felix Nagel',
	'author_email' => 'info@felixnagel.com',
	'shy' => '',
	'dependencies' => 'pluploadfe',
	'conflicts' => 'form',
	'priority' => '',
	'module' => '',
	'state' => 'beta',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.1.0',
	'constraints' => array(
		'depends' => array(
			'typo3' => '4.5.0-6.0.99',
			'pluploadfe' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:15:{s:9:"ChangeLog";s:4:"382f";s:12:"ext_icon.gif";s:4:"77b3";s:17:"ext_localconf.php";s:4:"3531";s:14:"ext_tables.php";s:4:"438e";s:14:"ext_tables.sql";s:4:"872b";s:13:"locallang.xml";s:4:"423c";s:16:"locallang_db.xml";s:4:"201a";s:10:"README.txt";s:4:"0c4a";s:14:"pi1/ce_wiz.gif";s:4:"02b6";s:30:"pi1/class.tx_mailfiles_pi1.php";s:4:"5290";s:38:"pi1/class.tx_mailfiles_pi1_wizicon.php";s:4:"e2ee";s:13:"pi1/clear.gif";s:4:"cc11";s:17:"pi1/locallang.xml";s:4:"4d04";s:20:"pi1/static/setup.txt";s:4:"e054";s:17:"res/template.html";s:4:"8779";}',
	'suggests' => array(
	),
);

?>