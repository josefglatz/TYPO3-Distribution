<?php
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
    'MAIL' => [
//        'transport' => 'smtp',
//        'transport_smtp_server' => 'SmtpServerHostname',
//        'transport_smtp_port' => 25,
//        'transport_smtp_encrypt' => 'tls',
//        'transport_smtp_username' => 'SmtpUser',
//        'transport_smtp_password' => 'SmtpPassword',
    ],
];

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $customChanges);
