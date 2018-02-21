<?php
defined('TYPO3_MODE') || die('Access denied.');

// Override configuration of LocalConfiguration
$customChanges = [
    'BE' => [
        'sessionTimeout' => 3600 * 10,
    ],
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
            'be_secure_pw' => serialize([
                'validUntil' => '316 years', // Period to remind the user (after login) for setting a new password. Please use english (e.g. "14 days")
                'forcePasswordChange' => 0, // Force changing the password: This disables all modules except user_setup to force a change of the password when the validUntil period is over or the checkbox in the be_user record  is set
                'passwordLength' => 12, // Length of the password: Here you can set the minimal length of the BE user password. If nothing is set, default is 8.
                'lowercaseChar' => true,
                'capitalChar' => true,
                'digit' => true,
                'specialChar' => true,
                'patterns' => 4, // Fitting patterns: How many patterns from above must fit to make the password secure
            ]),
            'page_speed' => serialize([
                'key' => '',
                'cacheTime' => 30,
                'demo' => 0,
            ]),
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
