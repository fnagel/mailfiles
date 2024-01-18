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
    'version' => '6.0.2-dev',
    'constraints' => [
        'depends' => [
            'php' => '7.4.0-8.1.99',
            'typo3' => '11.0.0-11.5.99',
            'pluploadfe' => '6.0.0-6.9.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
