<?php
defined('TYPO3_MODE') || die('Access denied.');

// Override configuration of LocalConfiguration
$customChanges = [
    'BE' => [
        'debug' => true,
        'installToolPassword' => '$P$C8R5CmXAuzvklF.d5eGuTS7eQquuQN1',
        'languageDebug' => false,
        'sessionTimeout' => 3600 * 24 * 365,
        'createGroup' => '',
        'versionNumberInFilename' => true,
    ],
    'EXT' => [
        'extConf' => [
            'realurl' => serialize([
                'configFile' => 'typo3conf/ext/theme/Resources/Private/Extension/Realurl/ManualConfiguration.php',
                'enableAutoConf' => 1,
                'autoConfFormat' => 1,
                'enableDevLog' => 0,
            ]),
        ],
    ],
    'FE' => [
        'debug' => true,
    ],
    'MAIL' => [
//        'transport' => 'mbox',
//        'transport_mbox_file' => PATH_site . 'mails.txt',
    ],
    'SYS' => [
        'devIPmask' => '*',
        'displayErrors' => true,
        'enableDeprecationLog' => 'file',
//        'exceptionalErrors' => 28674,
        'sqlDebug' => 1,
        'systemLogLevel' => 0,
        'systemLog' => '',
    ],
    'HTTP' => [
    ],
];

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $customChanges);

//if (extension_loaded('apc') && PHP_SAPI !== 'cli') {
//	$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_rootline']['backend'] =
//	$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_datamapfactory_datamap']['backend'] =
//	$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_object']['backend'] =
//	$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['t3lib_l10n']['backend'] =
//		'TYPO3\\CMS\\Core\\Cache\\Backend\\ApcBackend';
//}

// Automatic NullBackend for all caches in Development applicationContext
// see https://docs.typo3.org/typo3cms/CoreApiReference/CachingFramework/Configuration/Index.html?highlight=redisbackend#how-to-disable-specific-caches for more details
foreach ($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'] as $cacheName => $cacheConfiguration) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheName]['backend'] = \TYPO3\CMS\Core\Cache\Backend\NullBackend::class;
}

//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pagesection']['options'] =
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_hash']['options'] =
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pages']['options'] = array();
//
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pagesection']['backend'] =
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_hash']['backend'] =
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pages']['backend'] =
//	'TYPO3\\CMS\\Core\\Cache\\Backend\\TransientMemoryBackend';

// Uncommenting the two lines below will slow down request times dramatically
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_core']['backend'] = 'TYPO3\CMS\Core\Cache\Backend\NullBackend';
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['fluid_template']['backend'] = 'TYPO3\CMS\Core\Cache\Backend\NullBackend';

//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_hash']['backend'] = 'TYPO3\CMS\Core\Cache\Backend\NullBackend';
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pages']['backend'] = 'TYPO3\CMS\Core\Cache\Backend\NullBackend';
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_pagesection']['backend'] = 'TYPO3\CMS\Core\Cache\Backend\NullBackend';
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_phpcode']['backend'] = 'TYPO3\CMS\Core\Cache\Backend\NullBackend';
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_rootline']['backend'] = 'TYPO3\CMS\Core\Cache\Backend\NullBackend';
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_datamapfactory_datamap']['backend'] = 'TYPO3\CMS\Core\Cache\Backend\NullBackend';
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_object']['backend'] = 'TYPO3\CMS\Core\Cache\Backend\NullBackend';
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_reflection']['backend'] = 'TYPO3\CMS\Core\Cache\Backend\NullBackend';
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_typo3dbbackend_queries']['backend'] = 'TYPO3\CMS\Core\Cache\Backend\NullBackend';
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['l10n']['backend'] = 'TYPO3\CMS\Core\Cache\Backend\NullBackend';

// News caches
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_news_classes']['backend'] = 'TYPO3\CMS\Core\Cache\Backend\NullBackend';
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_news_category']['backend'] = 'TYPO3\CMS\Core\Cache\Backend\NullBackend';
