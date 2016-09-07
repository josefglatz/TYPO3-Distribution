<?php
defined('TYPO3_MODE') || die('Access denied.');

// Override configuration of LocalConfiguration
$customChanges = [
    'BE' => [
        'debug' => true,
        'installToolPassword' => '$P$C8R5CmXAuzvklF.d5eGuTS7eQquuQN1',
        'sessionTimeout' => 3600*24*7,
        'createGroup' => '',
        'versionNumberInFilename' => true,
    ],
    'FE' => [
        'debug' => true,
    ],
    'SYS' => [
        'curlUse' => true,
        'curlProxyServer' => '',
        'curlProxyUserPass' => '',
        'devIPmask' => '*',
        'displayErrors' => true,
        'enableDeprecationLog' => 'file',
        'sqlDebug' => 1,
        'systemLogLevel' => 0,
        'systemLog' => '',
    ],
    'HTTP' => [
        'proxy_host' => '',
        'proxy_password' => '',
        'proxy_port' => '',
        'proxy_user' => '',
        'ssl_verify_host' => '0',
    ],
];

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $customChanges);

//if (extension_loaded('apc')) {
//	$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_rootline']['backend'] =
//	$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_datamapfactory_datamap']['backend'] =
//	$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['extbase_object']['backend'] =
//	$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['t3lib_l10n']['backend'] =
//		'TYPO3\\CMS\\Core\\Cache\\Backend\\ApcBackend';
//}

//$cacheConfigurations = $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'];
//$cacheConfigurationsWithCachesSetToNullBackend = [];
//foreach ($cacheConfigurations as $cacheName => $cacheConfiguration) {
//    $cacheConfiguration['backend'] = \TYPO3\CMS\Core\Cache\Backend\NullBackend::class;
//    $cacheConfiguration['options'] = [];
//    $cacheConfigurationsWithCachesSetToNullBackend[$cacheName] = $cacheConfiguration;
//}