<?php declare(strict_types=1);
defined('TYPO3_MODE') || die('Access denied.');

// Override configuration of LocalConfiguration
$customChanges = [
    'DB' => [
        'Connections' => [
            'Default' => [
                'charset' => 'utf8',
                'dbname' => '',
                'driver' => 'mysqli',
                'host' => '',
                'password' => '',
                'port' => 3306,
                'user' => '',
            ],
        ],
    ],
    'EXT' => [
        'extConf' => [
            'page_speed' => serialize([
                'key' => '',
                'cacheTime' => 30,
                'demo' => 0,
            ]),
        ],
    ],
];

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $customChanges);
