<?php

declare(strict_types=1);
defined('TYPO3_MODE') || die('Access denied.');

// Override configuration of LocalConfiguration
$customChanges = [
    'DB' => [
        'Connections' => [
            'Default' => [
                'charset' => 'utf8',
                'dbname' => getenv('MYSQL_DATABASE'),
                'driver' => 'mysqli',
                'host' => 'mysql',
                'password' => getenv('MYSQL_PASSWORD'),
                'port' => 3306,
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
        'processor_path' => '/usr/bin/',
        'processor_path_lzw' => '/usr/bin/',
    ],
];

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $customChanges);
