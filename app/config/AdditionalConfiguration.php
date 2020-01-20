<?php
declare(strict_types=1);
defined('TYPO3_MODE') || die('Access denied.');

use TYPO3\CMS\Core\Cache\Backend\RedisBackend;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Log\Writer\FileWriter;
use TYPO3\CMS\Core\Resource\Collection\StaticFileCollection;
use TYPO3\CMS\Core\Session\Backend\RedisSessionBackend;
use TYPO3\CMS\Core\Utility\GeneralUtility;

// set instance values
$site = [
    'sitenameBase' => 'TYPO3 Distribution',
    'defaultMailFromAddress' => 'no-reply@example.at',
    'defaultMailFromName' => 'TYPO3 Distribution',
    'defaultMailReplyToAddress' => 'office@example.at',
    'defaultMailReplyToName' => 'TYPO3 Distribution',
    'backendLogo' => 'BackendLogo',
];

$context = GeneralUtility::getApplicationContext()->__toString();
[$contextMainPart, $contextSubPart1, $contextSubPart2] = explode('/', $context);
$loadPass = function ($envName) {
    $file = getenv($envName . '_FILE');

    if ($file && file_exists($file)) {
        return (string)file_get_contents($file);
    }

    return (string)getenv($envName);
};

$logLevel = GeneralUtility::getApplicationContext()->isDevelopment() ? LogLevel::DEBUG : LogLevel::WARNING;
$logDir = Environment::getVarPath() . '/log/typo3/';

$redisHost = (string)getenv('REDIS_HOST_NAME');
$redisPort = (int)getenv('REDIS_HOST_PORT');
$redisAuth = (string)getenv('REDIS_AUTH');
$redisFirstDatabase = (int)getenv('REDIS_FIRST_DATABASE');


// set context specific TYPO3 backend logo @TODO: TYPO3-Distribution: Move backendLogo logic into own extensions #393
$backendLogoFilePathAndFilePrefix = realpath(__DIR__) . '/ext/theme/Resources/Public/Images/Backend/' . $site['backendLogo'] . '-';
$backendLogoFileSuffix = '.svg';
$backendLogo = $backendLogoFilePathAndFilePrefix . $contextMainPart . $backendLogoFileSuffix;
if (is_file($backendLogo)) {
    $site['backendLogo'] = $site['backendLogo'] . '-' . $contextMainPart;
}
$backendLogo = $backendLogoFilePathAndFilePrefix . $contextMainPart . '-' . $contextSubPart1 . $backendLogoFileSuffix;
if (is_file($backendLogo)) {
    $site['backendLogo'] .= '-' . $contextSubPart1;
}
$backendLogo = $backendLogoFilePathAndFilePrefix . $contextMainPart . '-' . $contextSubPart1 . '-' . $contextSubPart2 . $backendLogoFileSuffix;
if (is_file($backendLogo)) {
    $site['backendLogo'] .= '-' . $contextSubPart2;
}

// project specific configuration
$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], [
    'BE' => [
        'debug'              => true,
        'explicitADmode' => 'explicitAllow',
        'loginSecurityLevel' => 'normal',
        'notificationPrefix' => '[' . htmlspecialchars($site['sitenameBase']) . ' TYPO3 Note]',
        'passwordHashing'    => [
            'className' => \TYPO3\CMS\Core\Crypto\PasswordHashing\Argon2iPasswordHash::class,
            'options'   => [],
        ],
    ],
    'DB' => [
        'Connections' => [
            'Default' => [
                'charset'      => 'utf8mb4',
                'dbname'       => getenv('MYSQL_DATABASE'),
                'driver'       => 'mysqli',
                'host'         => getenv('MYSQL_HOST'),
                'password'     => $loadPass('MYSQL_PASSWORD'),
                'port'         => getenv('MYSQL_PORT'),
                'tableoptions' => [
                    'charset' => 'utf8mb4',
                    'collate' => 'utf8mb4_unicode_ci',
                ],
                'user' => getenv('MYSQL_USER'),
            ],
        ],
    ],
    'EXTCONF' => [
        'lang' => [
            'availableLanguages' => [
                'de',
            ],
        ],
        'theme' => [
            'sharing' => [
                'opengraph' => [
                    'allowedImageFileExt' => 'gif,jpg,jpeg,png',
                ],
            ],
            'content' => [
                'youtube' => [
                    'coverImage' => [
                        'allowedImageFileExt' => 'jpg,jpeg,png',
                    ],
                ],
                'theme_logo_cemetery' => [
                    'logoImage' => [
                        'allowedImageFileExt' => 'gif,jpg,jpeg,png,svg',
                    ],
                ],
                'theme_facts_figures' => [
                    'factImage' => [
                        'allowedImageFileExt' => 'svg',
                    ],
                ],
            ],
            'pages' => [
                'tx_theme_nav_image' => [
                    'default' => [
                        'allowedImageFileExt' => 'jpg,jpeg,png',
                    ],
                ],
            ],
        ],
    ],
    'EXTENSIONS' => [
        'backend' => [
            'loginLogo' => 'EXT:theme/Resources/Public/Images/Backend/Login/LoginLogo.svg',
            'loginHighlightColor' => '#ff8700',
            'loginBackgroundImage' => 'EXT:theme/Resources/Public/Images/Backend/Login/Background.png',
            'loginFootnote' => 'This is a demo TYPO3 backend login footnote.',
            'backendLogo' => 'EXT:theme/Resources/Public/Images/Backend/' . $site['backendLogo'] . '.svg', // custom backend logo must not by higher than 37px
            'backendFavicon' => 'EXT:backend/Resources/Public/Icons/favicon.ico',
        ],
        'be_secure_pw' => [
            'validUntil' => '6 months', // Period to remind the user (after login) for setting a new password. Please use english (e.g. "14 days")
            'forcePasswordChange' => 0, // Force changing the password: This disables all modules except user_setup to force a change of the password when the validUntil period is over or the checkbox in the be_user record  is set
            'passwordLength' => 12, // Length of the password: Here you can set the minimal length of the BE user password. If nothing is set, default is 8.
            'lowercaseChar' => true,
            'capitalChar' => true,
            'digit' => true,
            'specialChar' => true,
            'patterns' => 4, // Fitting patterns: How many patterns from above must fit to make the password secure
        ],
        'cropvariantsbuilder' => [
            'configurationProviderExtension' => 'theme',
            'configurationProviderLocallangFilename' => 'locallang',
        ],
        'fluid_styled_content' => [
            'loadContentElementWizardTsConfig' => 1,
        ],
        'gdpr' => [
            'overloadMediaRenderer' => false,
            'randomizerLocale' => 'de_DE',
        ],
        'gravatar' => [
            'fallback' => '', // Fallback behaviour: see https://www.gravatar.com/site/implement/images/  // Transparent/blank=, mystery-man=mm, identicon=identicon, monsterid=monsterid, wavatar=wavatar, retro=retro, Use fallback image=url
            'fallbackImageUrl' => '', // Fallback image url: MUST be publicly available, see https://www.gravatar.com/site/implement/images/
            'forceProvider' => false,
            'useProxy' => true, // Improve privacy by proxying the image request
        ],
        'iconcheck' => [
            'listAllIconIdentifiers' => 1,
            'listIconsWithPrefix' => 'theme-backend, theme-belayout, theme-content, content, apps-pagetree',
            'enableModuleForEverybody' => 0,
            'disableModule' => 0,
        ],
        'mask' => [
            'json' => 'typo3conf/ext/theme_project/Resources/Private/Mask/mask.json',                   // Path of generated ext:mask config file
            'backendlayout_pids' => '0,1',                                                              // PageIds from where the in PageTS defined backend layouts should be loaded (comma separated)
            'content' => 'typo3conf/ext/theme_project/Resources/Private/Mask/Templates/Content/',            // Folder for Content Fluid Templates (with trailing slash)
            'layouts' => 'typo3conf/ext/theme_project/Resources/Private/Mask/Layouts/',                      // Folder for Content Fluid Layouts (with trailing slash)
            'partials' => 'typo3conf/ext/theme_project/Resources/Private/Mask/Partials/',                    // Folder for Content Fluid Partials (with trailing slash)
            'backend' => 'typo3conf/ext/theme_project/Resources/Private/Mask/Backend/Templates/',            // Folder for Backend Preview Templates (with trailing slash)
            'layouts_backend' => 'typo3conf/ext/theme_project/Resources/Private/Mask/Backend/Layouts/',      // Folder for Backend Preview Layouts (with trailing slash)
            'partials_backend' => 'typo3conf/ext/theme_project/Resources/Private/Mask/Backend/Partials/',    // Folder for Backend Preview Partials (with trailing slash)
            'preview' => 'typo3conf/ext/theme_project/Resources/Private/Mask/Backend/PreviewImages/',        // Folder for preview-images (with trailing slash)
        ],
        'news' => [
            'prependAtCopy' => 0,
            'tagPid' => 1,
            'rteForTeaser' => 0,
            'contentElementRelation' => 1,
            'contentElementPreview' => 1,
            'manualSorting' => 0,
            'categoryRestriction' => 'none',
            'categoryBeGroupTceFormsRestriction' => 0,
            'dateTimeNotRequired' => 0,
            'archiveDate' => 'date',
            'mediaPreview' => false,
            'advancedMediaPreview' => 1,
            'showAdministrationModule' => 1,
            'hidePageTreeForAdministrationModule' => 0,
            'showImporter' => 0,
            'storageUidImporter' => '1',
            'resourceFolderImporter' => '/news_import',
        ],
        'page_speed' => [
            'key' => '',
            'cacheTime' => 86400,
            'demo' => 1,
        ],
        'rx_shariff' => [
            'services' => 'Facebook, LinkedIn, Reddit, StumbleUpon, Flattr, Pinterest, Xing, AddThis',
            'allowedDomains' => 'SERVER_NAME',
            'ttl' => 3600,
            'facebook_app_id' => '',
            'facebook_secret' => '',
        ],
        'scheduler' => [
            'maxLifetime' => 1440,
            'showSampleTasks' => 0,
        ],
        'theme' =>  [
            'pageLayoutViewEnrichmentFooter' => 1,
        ],
        't3monitoring_client' => [
            'secret' => '!!!',
            'allowedIps' => '*',
            'enableDebugForErrors' => 0,
        ],
        'vhs' => [
            'disableAssetHandling' => 1,
        ],
    ],
    'FE' => [
        'disableNoCacheParameter' => true,
        'hidePagesIfNotTranslatedByDefault' => true,
        'loginSecurityLevel' => 'normal',
        'passwordHashing'    => [
            'className' => \TYPO3\CMS\Core\Crypto\PasswordHashing\Argon2iPasswordHash::class,
            'options'   => [],
        ],
        'versionNumberInFilename' => 'querystring',
    ],
    'GFX' => [
        'jpg_quality' => '86',
        'processor_allowUpscaling' => false,
        'imagefile_ext' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'] . ',eps',
        'processor' => 'GraphicsMagick',
        'processor_allowTemporaryMasksAsPng' => false,
        'processor_colorspace' => 'RGB',
        'processor_effects' => -1,
        'processor_enabled' => true,
        'processor_path' => '/usr/bin/',
        'processor_path_lzw' => '/usr/bin/',
    ],
    'MAIL' => [
        'defaultMailFromAddress' => $site['defaultMailFromAddress'],
        'defaultMailFromName' => $site['defaultMailFromName'],
        'defaultMailReplyToAddress' => $site['defaultMailReplyToAddress'],
        'defaultMailReplyToName' => $site['defaultMailReplyToName'],
        'transport'                  => 'smtp',
        'transport_sendmail_command' => '',
        'transport_smtp_encrypt'     => (string)getenv('SMTP_ENCRYPT'),
        'transport_smtp_password'    => $loadPass('SMTP_PASSWORD'),
        'transport_smtp_server'      => getenv('SMTP_HOST_NAME') . ':' . getenv('SMTP_HOST_PORT'),
        'transport_smtp_username'    => (string)getenv('SMTP_USER'),
    ],
    'SYS' => [
        'caching' => [
            'cacheConfigurations' => [
                /* @TODO Until an solution is provided by the core https://forge.typo3.org/issues/78140 */
                'extbase_object' => [
                    'backend' => TYPO3\CMS\Core\Cache\Backend\Typo3DatabaseBackend::class,
                    'frontend' => TYPO3\CMS\Core\Cache\Frontend\VariableFrontend::class,
                    'groups' => [
                        'system',
                    ],
                    'options' => [
                        'defaultLifetime' => 0,
                    ],
                ],
            ],
        ],
        'devIPmask'           => '',
        'displayErrors'       => 0,
        'exceptionalErrors'   => E_ALL & ~(E_STRICT | E_NOTICE | E_WARNING | E_USER_DEPRECATED | E_DEPRECATED | E_RECOVERABLE_ERROR),
        'fal' => [
            'registeredCollections' => [
                'tx_theme_images' => StaticFileCollection::class,
            ],
        ],
        'features' => [
            'TypoScript.strictSyntax'                   => true,
            'redirects.hitCount'                        => false,
            'security.frontend.keepSessionDataOnLogout' => false,
            'simplifiedControllerActionDispatching'     => true,
            'unifiedPageTranslationHandling'            => true,
        ],
        'fluid' => [
            'namespaces' => [
                'theme' => [
                    'JosefGlatz\\Theme\\ViewHelpers',
                ],
            ],
        ],
        'ipAnonymization' => 2,
        'UTF8filesystem' => true,
        'systemLocale' => 'de_DE.utf8',
        'cookieSecure' => 2,
        'sitename' => htmlspecialchars($site['sitenameBase']) . ' [' . $context . ']',
        'systemLogLevel'    => 0,
        'systemMaintainers' => [
            1,
        ],
    ],
]);

$GLOBALS['TYPO3_CONF_VARS']['LOG'] = [
    'writerConfiguration' => [
        $logLevel => [
            FileWriter::class => [
                'logFile' => $logDir . 'typo3.log',
            ],
        ],
    ],
    'TYPO3' => [
        'CMS' => [
            'deprecations' => [
                'writerConfiguration' => [
                    $logLevel => [
                        FileWriter::class => [
                            'logFile' => $logDir . 'deprecations.log',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'JosefGlatz' => [
        'writerConfiguration' => [
            $logLevel => [
                FileWriter::class => [
                    'logFile' => $logDir . 'josefglatz.log',
                ],
            ],
        ],
    ],
    'Supseven' => [
        'writerConfiguration' => [
            $logLevel => [
                FileWriter::class => [
                    'logFile' => $logDir . 'supseven.log',
                ],
            ],
        ],
    ],
    'ApacheSolrForTypo3' => [
        'Solr' => [
            'writerConfiguration' => [
                $logLevel => [
                    FileWriter::class => [
                        'logFile' => $logDir . 'solr.log',
                    ],
                ],
            ],
        ],
    ],
];

if ($redisHost && $redisPort && class_exists(Redis::class)) {
    $cacheNames = [
        'cache_pages',
        'cache_pagesection',
        'cache_rootline',
        'cache_hash',
        'extbase_datamapfactory_datamap',
        'extbase_reflection',
        'l10n',
        'cache_ttaddress_category',
        'cache_news_category',
        'tx_solr',
        'tx_solr_configuration',
    ];

    $i = $redisFirstDatabase ?? $redisFirstDatabase + 2;

    foreach ($cacheNames as $cacheName) {
        $cache = $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheName] ?? [];
        $cache['backend'] = RedisBackend::class;
        $cache['options'] = [
            'hostname' => $redisHost,
            'port'     => $redisPort,
            'password' => $redisAuth,
            'database' => $i++,
        ];

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$cacheName] = $cache;
    }

    $GLOBALS['TYPO3_CONF_VARS']['SYS']['session'] = [
        'BE' => [
            'backend' => RedisSessionBackend::class,
            'options' => [
                'database' => $redisFirstDatabase,
                'hostname' => $redisHost,
                'port'     => $redisPort,
                'password' => $redisAuth,
            ],
        ],
        'FE' => [
            'backend' => RedisSessionBackend::class,
            'options' => [
                'database' => ++$redisFirstDatabase,
                'hostname' => $redisHost,
                'port'     => $redisPort,
                'password' => $redisAuth,
            ],
        ],
    ];
}

$base = substr(realpath(__FILE__), 0, -4);

foreach (explode('/', $context) as $contextPart) {
    $base .= '_' . $contextPart;
    $file = $base . '.php';

    if (file_exists($file)) {
        include_once $file;
    }
}
