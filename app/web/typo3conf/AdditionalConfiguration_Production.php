<?php declare(strict_types=1);
defined('TYPO3_MODE') || die('Access denied.');

// Override configuration of LocalConfiguration
$customChanges = [
    'BE' => [
        'debug' => false,
        'warning_email_addr' => '',
        'warning_mode' => '',
        'adminOnly' => '0',
    ],
    'EXT' => [
        'extConf' => [
            'page_speed' => serialize([
                'key' => '',
                'cacheTime' => 86400,
                'demo' => 0,
            ]),
        ],
    ],
    'FE' => [
        'debug' => false,
    ],
    'GFX' => [
    ],
    'SYS' => [
        'displayErrors' => false,
        'enableDeprecationLog' => '',
        'sqlDebug' => 0,
        'systemLogLevel' => 4,
    ],
    'LOG' => [
        'writerConfiguration' => [
            \TYPO3\CMS\Core\Log\LogLevel::DEBUG => [
                \TYPO3\CMS\Core\Log\Writer\NullWriter::class => []
            ]
        ],
    ],
];

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $customChanges);

if (extension_loaded('apc') && PHP_SAPI !== 'cli') {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_rootline']['backend'] =
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_datamapfactory_datamap']['backend'] =
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_object']['backend'] =
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_typo3dbbackend_tablecolumns']['backend'] =
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['t3lib_l10n']['backend'] =
        'TYPO3\\CMS\\Core\\Cache\\Backend\\ApcBackend';
}
