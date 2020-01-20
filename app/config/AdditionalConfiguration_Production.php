<?php
declare(strict_types=1);

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], [
    'BE' => [
        'debug'   => true,
        'warning_email_addr' => '',
        'warning_mode' => 0,
        'adminOnly' => '0',
        'lockSSL' => true,
    ],
    'FE' => [
        'debug' => false,
    ],
    'SYS' => [
        'displayErrors' => false,
        'exceptionalErrors' => E_ALL & ~(E_STRICT | E_NOTICE | E_DEPRECATED | E_USER_DEPRECATED | E_WARNING),
    ],
]);
