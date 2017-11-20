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
//        'transport_mbox_file' => dirname(PATH_site) . 'mails.txt',
    ],
    'SYS' => [
        'devIPmask' => '*',
        'displayErrors' => false,
        'enableDeprecationLog' => 'file',
//        'exceptionalErrors' => 28674,
        'sqlDebug' => 1,    // 0 = no debug; 1 = only failed queries; 2 = all queries
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
//	$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['l10n']['backend'] =
//		'TYPO3\\CMS\\Core\\Cache\\Backend\\ApcBackend';
//}

// Automatic NullBackend for all caches while developing
// see https://docs.typo3.org/typo3cms/CoreApiReference/CachingFramework/Configuration/Index.html?highlight=redisbackend#how-to-disable-specific-caches for more details
foreach ($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'] as $cacheName => $cacheConfiguration) {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheName]['backend'] = \TYPO3\CMS\Core\Cache\Backend\NullBackend::class;
}

// Uncommenting the two lines below will spped up request times dramatically BUT isn't helpful when integrating or writing extensions
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_core']['backend'] = \TYPO3\CMS\Core\Cache\Backend\SimpleFileBackend::class;
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['fluid_template']['backend'] = \TYPO3\CMS\Core\Cache\Backend\SimpleFileBackend::class;
