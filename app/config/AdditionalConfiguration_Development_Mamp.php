<?php
declare(strict_types=1);

/*
 * Example configuration block for MAMP's Apache host directives:
 *
 * Pre-requirements:
 * - Create your database before installing/running project
 * - Set your mysql server port if you use an alternative
 */
/*

SetEnv TYPO3_CONTEXT "Development/Mamp"
SetEnv MYSQL_USER "root"
SetEnv MYSQL_PASSWORD "root"
SetEnv MYSQL_DATABASE "projectDatabase"
SetEnv MYSQL_PORT "8889"

 */

/*
 * Run PHP CLI like:
 */
/*
 *
    MYSQL_USER=distri MYSQL_PASSWORD=distri MYSQL_DATABASE=distri MYSQL_PORT=8889 TYPO3_CONTEXT=Development/Mamp /Applications/MAMP/bin/php/php7.1.12/bin/php ./typo3cms
    MYSQL_USER=distri MYSQL_PASSWORD=distri MYSQL_DATABASE=distri MYSQL_PORT=8889 TYPO3_CONTEXT=Development/Mamp /Applications/MAMP/bin/php/php7.2.8/bin/php ./typo3cms

 */

// Override configuration of LocalConfiguration
$customChanges = [
    'DB' => [
        'Connections' => [
            'Default' => [
                'dbname' => getenv('MYSQL_DATABASE'),
                'driver' => 'mysqli',
                'host' => 'localhost',
                'password' => getenv('MYSQL_PASSWORD'),
                'port' => getenv('MYSQL_PORT'),
                'user' => getenv('MYSQL_USER'),
            ],
        ],
    ],
    'GFX' => [
        'colorspace' => 'RGB',
        'processor' => 'GraphicsMagick',
        'processor_allowTemporaryMasksAsPng' => false,
        'processor_colorspace' => 'RGB',
        'processor_effects' => -1,
        'processor_enabled' => true,
        'processor_path' => '/usr/local/bin/',
        'processor_path_lzw' => '/usr/local/bin/',
    ],
    'SYS' => [
        'systemLocale' => 'de_DE.UTF-8',
    ],
];

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $customChanges);
