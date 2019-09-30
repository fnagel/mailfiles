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

$EM_CONF[$_EXTKEY] = [
    'title' => 'Mail Files',
    'description' => 'Upload files and send download links via email. Uses plupload. Please see readme file.',
    'category' => 'plugin',
    'author' => 'Felix Nagel',
    'author_email' => 'info@felixnagel.com',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => 0,
    'clearCacheOnLoad' => 0,
    'version' => '3.0.1-dev',
    'constraints' => [
        'depends' => [
            'php' => '7.0.0-7.2.99',
            'typo3' => '8.7.0-9.5.99',
            'pluploadfe' => '2.0.0-3.0.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
