<?php
declare(strict_types=1);

use TYPO3\CMS\Core\Cache\Backend\NullBackend;
use TYPO3\CMS\Core\Cache\Backend\PhpCapableBackendInterface;
use TYPO3\CMS\Core\Cache\Backend\TransientMemoryBackend;


// Override configuration of LocalConfiguration
$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], [
    'BE' => [
        'debug' => true,
        // joh316
        'installToolPassword' => '$argon2i$v=19$m=16384,t=16,p=2$aDZHUmRqTUFUR1dpYWlqdA$aR5bQdCiYwZ6ClUPpTzMqhnQt24CprQWKU2VavXp3T4',
        'languageDebug' => false,
        'sessionTimeout' => 31536000,
    ],
    'FE' => [
        'debug' => true,
        'sessionTimeout' => 31536000,
    ],
    'SYS' => [
        'devIPmask' => '*',
        'displayErrors' => true,
        'exceptionalErrors'   => E_ALL & ~(E_STRICT | E_NOTICE | E_DEPRECATED | E_USER_DEPRECATED),
        'trustedHostsPattern' => '.*',
    ],
]);

foreach ($GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'] as $name => &$cache) {
    $cache['options'] = [];

    if (!empty($cache['backend']) && in_array(PhpCapableBackendInterface::class, class_implements($cache['backend']), true)) {
        $cache['backend'] = NullBackend::class;
    } else {
        $cache['backend'] = TransientMemoryBackend::class;
    }
}

// Uncommenting the two lines below will speed up request times dramatically BUT isn't helpful when integrating or writing extensions
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['cache_core']['backend'] = \TYPO3\CMS\Core\Cache\Backend\SimpleFileBackend::class;
//$GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations']['fluid_template']['backend'] = \TYPO3\CMS\Core\Cache\Backend\SimpleFileBackend::class;


