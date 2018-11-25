<?php

defined('TYPO3_MODE') || die('Access denied.');


// @TODO: redis backend pConnect feature (7d0c8befc5999627edefb340cef270707c2956bd)
// TODO: Add central password config for redis configs
// TODO: generate config via simple foreach iterations (check https://www.mittwald.de/faq/frage/apcu-mit-typo3-verwenden therefore)


// Override configuration of LocalConfiguration
$customChanges = [
    'BE' => [
        'debug' => false,
        'warning_email_addr' => '',
        'warning_mode' => '',
        'adminOnly' => '0',
    ],
    'FE' => [
        'debug' => false,
    ],
    'GFX' => [
    ],
    'SYS' => [
        'displayErrors' => false,
        'sqlDebug' => 0,
        'systemLogLevel' => 4,
        'caching' => [
            'cacheConfigurations' => [
                'cache_pages' => [
                    'backend' => \TYPO3\CMS\Core\Cache\Backend\RedisBackend::class,
                    'options' => [
                        'defaultLifetime' => 86400,
                        'database' => 0
                    ]
                ],
                'cache_pagesection' => [
                    'backend' => \TYPO3\CMS\Core\Cache\Backend\RedisBackend::class,
                    'options' => [
                        'defaultLifetime' => 86400,
                        'database' => 1
                    ]
                ],
                'cache_hash' => [
                    'backend' => \TYPO3\CMS\Core\Cache\Backend\RedisBackend::class,
                    'options' => [
                        'defaultLifetime' => 86400,
                        'database' => 2
                    ]
                ]
            ]
        ],
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

if (extension_loaded('apcu') && PHP_SAPI !== 'cli') {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_rootline']['backend'] =
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_datamapfactory_datamap']['backend'] =
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_object']['backend'] =
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_reflection']['backend'] =
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['l10n']['backend'] =
        \TYPO3\CMS\Core\Cache\Backend\ApcuBackend::class;
}
