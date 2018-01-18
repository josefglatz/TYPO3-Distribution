<?php
use TYPO3\CMS\Core\Utility\GeneralUtility;

defined('TYPO3_MODE') || die('Access denied.');

// set instance values
$site = [
    'sitenameBase' => 'TYPO3 Distribution',
    'defaultMailFromAddress' => 'no-reply@example.at',
    'defaultMailFromName' => 'TYPO3 Distribution',
    'backendLogo' => 'BackendLogo',
];

// get complete context
$context = GeneralUtility::getApplicationContext()->__toString();

if ($context) {
    // check for "Production/Live/Server123" etc
    list($contextMainPart, $contextSubPart1, $contextSubPart2) = explode('/', $context);

    // set context specific TYPO3 backend logo
    if (TYPO3_MODE === 'BE') {
        $backendLogoFilePathAndFilePrefix = realpath(__DIR__) . '/ext/theme/Resources/Public/Images/Backend/' . $site['backendLogo'] . '-';
        $backendLogoFileSuffix = '.svg';
        $backendLogo = $backendLogoFilePathAndFilePrefix . $contextMainPart . $backendLogoFileSuffix;
        if (is_file($backendLogo)) {
            $site['backendLogo'] .= '-' . $contextMainPart;
        }
        $backendLogo = $backendLogoFilePathAndFilePrefix . $contextMainPart . '-' . $contextSubPart1 . $backendLogoFileSuffix;
        if (is_file($backendLogo)) {
            $site['backendLogo'] .= '-' . $contextMainPart . '-' . $contextSubPart1;
        }
        $backendLogo = $backendLogoFilePathAndFilePrefix . $contextMainPart . '-' . $contextSubPart1 . '-' . $contextSubPart2 . $backendLogoFileSuffix;
        if (is_file($backendLogo)) {
            $site['backendLogo'] .= '-' . $contextMainPart . '-' . $contextSubPart1 . '-' . $contextSubPart2;
        }
    }
}

// project specific configuration
$customChanges = [
    'BE' => [
        'explicitADmode' => 'explicitAllow',
        'loginSecurityLevel' => 'rsa',
        'notificationPrefix' => '[' . htmlspecialchars($site['sitenameBase']) . ' TYPO3 Note]',
    ],
    'DB' => [
        'Connections' => [
            'Default' => [
                'charset' => 'utf8',
                'driver' => 'mysqli',
            ],
        ],
    ],
    'EXTCONF' => [
        'lang' => [
            'availableLanguages' => [
                'de',
            ],
        ],
    ],
    'EXT' => [
        'extConf' => [
            'backend' => serialize([
                'loginLogo' => 'EXT:theme/Resources/Public/Images/Backend/Login/LoginLogo.svg',
                'loginHighlightColor' => '#ff8700',
                'loginBackgroundImage' => 'EXT:theme/Resources/Public/Images/Backend/Login/Background.png',
                'backendLogo' => 'EXT:theme/Resources/Public/Images/Backend/' . $site['backendLogo'] . '.svg', // custom backend logo should not by higher than 37px
                // @TODO: Backend Logo (Stage, Prod, Dev)
                'backendFavicon' => 'EXT:backend/Resources/Public/Icons/favicon.ico',
                // @TODO: Backend FavIcon (Stage, Prod, Dev)
            ]),
            'be_secure_pw' => serialize([
                'validUntil' => '6 months', // Period to remind the user (after login) for setting a new password. Please use english (e.g. "14 days")
                'forcePasswordChange' => 0, // Force changing the password: This disables all modules except user_setup to force a change of the password when the validUntil period is over or the checkbox in the be_user record  is set
                'passwordLength' => 12, // Length of the password: Here you can set the minimal length of the BE user password. If nothing is set, default is 8.
                'lowercaseChar' => true,
                'capitalChar' => true,
                'digit' => true,
                'specialChar' => true,
                'patterns' => 4, // Fitting patterns: How many patterns from above must fit to make the password secure
            ]),
            'beuser_fastswitch' => serialize([
                'allowedUserNamePattern' => '',
                'allowedUserEmailAddressPattern' => '',
                'allowedUserGroupUids' => '',
                'allowedUserGroupNamePattern' => '',
                'showAdminUsers' => 0,
                'activeSearchbox' => 0,
                'defaultListing' => 'default',
            ]),
            'extractor' => serialize([
                'enable_tika' => 0,
                'enable_tools_exiftool' => 0,
                'enable_tools_pdfinfo' => 0,
                'enable_php' => 1,
                'auto_extract' => 0,
                'tika_mode' => 'jar',
                'tika_jar_path' => '',
                'tika_server_host' => '',
                'tika_server_port' => 9998,
                'tools_exiftool' => '',
                'tools_pdfinfo' => '',
                'mapping_base_directory' => 'EXT:extractor/Configuration/Services/',
                'mapping_configuration' => ''
            ]),
            'extensionmanager' => serialize([
                'automaticInstallation' => 1,
                'offlineMode' => 0,
            ]),
            'fluid_styled_content' => serialize([
                'loadContentElementWizardTsConfig' => 1,
            ]),
            'gravatar' => serialize([
                'fallback' => '', // Fallback behaviour: see https://www.gravatar.com/site/implement/images/  // Transparent/blank=, mystery-man=mm, identicon=identicon, monsterid=monsterid, wavatar=wavatar, retro=retro, Use fallback image=url
                'fallbackImageUrl' => '', // Fallback image url: MUST be publicly available, see https://www.gravatar.com/site/implement/images/
                'forceProvider' => false, // Use Gravatar service even if email address is empty: Normally the Gravatar service is only requested when a email address is set. With this setting you can also enable is for BE users without email address. The above fallback will always be used then.
                'useProxy' => true, // Improve privacy by proxying the image request
            ]),
            'image_autoresize_ff' => serialize([
                'directories' => 'fileadmin/,uploads/',
                'file_types' => 'jpg,jpeg,png',
                'threshold' => '400K',
                'max_width' => 1024,
                'max_height' => 768,
                'auto_orient' => 1,
                'conversion_mapping' => 'ai => jpg,bmp => jpg,pcx => jpg,tga => jpg,tif => jpg,tiff => jpg',
                'keep_metadata' => 0,
                'resize_png_with_alpha' => 0,
            ]),
            'lfeditor' => serialize([
                'viewLanguages' => '', // cz,de,fr,hr,hu,it,nl,pl,ru,sk
                'defaultLanguage' => '',
                'extIgnore' => '/^(CVS|.svn|.git|csh_)/',
                'changeXlfDate' => 1,
            ]),
            'mask' => serialize([
                'json' => 'typo3conf/ext/theme_project/Resources/Private/Mask/mask.json',                   // Path of generated ext:mask config file
                'backendlayout_pids' => '0,1',                                                              // PageIds from where the in PageTS defined backend layouts should be loaded (comma separated)
                'content' => 'typo3conf/ext/theme_project/Resources/Private/Mask/Templates/Content/',            // Folder for Content Fluid Templates (with trailing slash)
                'layouts' => 'typo3conf/ext/theme_project/Resources/Private/Mask/Layouts/',                      // Folder for Content Fluid Layouts (with trailing slash)
                'partials' => 'typo3conf/ext/theme_project/Resources/Private/Mask/Partials/',                    // Folder for Content Fluid Partials (with trailing slash)
                'backend' => 'typo3conf/ext/theme_project/Resources/Private/Mask/Backend/Templates/',            // Folder for Backend Preview Templates (with trailing slash)
                'layouts_backend' => 'typo3conf/ext/theme_project/Resources/Private/Mask/Backend/Layouts/',      // Folder for Backend Preview Layouts (with trailing slash)
                'partials_backend' => 'typo3conf/ext/theme_project/Resources/Private/Mask/Backend/Partials/',    // Folder for Backend Preview Partials (with trailing slash)
                'preview' => 'typo3conf/ext/theme_project/Resources/Private/Mask/Backend/PreviewImages/',        // Folder for preview-images (with trailing slash)
            ]),
            'mask_export' => serialize([
                'contentElementIcons' => 1,    // If enabled the export includes icons for content elements.
                'backendPreview' => 1,         // If enabled the export contains some PHP and Fluid files to show a record preview in the page layout.
            ]),
            'news' => serialize([
                'archiveDate' => 'date',
                'rteForTeaser' => 0,
                'tagPid' => 1,
                'prependAtCopy' => 0,
                'categoryRestriction' => 'none',
                'categoryBeGroupTceFormsRestriction' => 0,
                'contentElementRelation' => 1,
                'manualSorting' => 0,
                'dateTimeNotRequired' => 0,
                'showAdministrationModule' => 0,
                'showImporter' => 0,
                'storageUidImporter' => '1',
                'resourceFolderImporter' => '/news_import',
            ]),
            'page_speed' => serialize([
                'key' => '',
                'cacheTime' => 86400,
                'demo' => 1,
            ]),
            'realurl' => serialize([
                'configFile' => 'typo3conf/ext/theme/Resources/Private/Extension/Realurl/ManualConfiguration.php',
                'enableAutoConf' => 1,
                'autoConfFormat' => 0,
                'enableDevLog' => 0,
                'moduleIcon' => 0,
            ]),
            'rsaauth' => serialize([
                'temporaryDirectory' => '',
            ]),
            'rx_shariff' => serialize([
                'services' => 'GooglePlus, Facebook, LinkedIn, Reddit, StumbleUpon, Flattr, Pinterest, Xing, AddThis',
                'allowedDomains' => 'SERVER_NAME',
                'ttl' => 3600,
                'facebook_app_id' => '',
                'facebook_secret' => '',
            ]),
            'saltedpasswords' => serialize([
                'BE.' => [
                    'saltedPWHashingMethod' => \TYPO3\CMS\Saltedpasswords\Salt\Pbkdf2Salt::class, // Default since 8-7 (for legacy reasons still here)
                    'forceSalted' => 0,
                    'onlyAuthService' => 0,
                    'updatePasswd' => 1,
                ],
                'FE.' => [
                    'enabled' => 1,
                    'saltedPWHashingMethod' => \TYPO3\CMS\Saltedpasswords\Salt\Pbkdf2Salt::class, // Default since 8-7 (for legacy reasons still here)
                    'forceSalted' => 0,
                    'onlyAuthService' => 0,
                    'updatePasswd' => 1,
                ],
            ]),
            'scheduler' => serialize([
                'maxLifetime' => 1440,
                'enableBELog' => 0,
                'showSampleTasks' => 0,
                'useAtDaemon' => 0,
            ]),
            'seo_basics' => serialize([
                'xmlSitemap' => 0,
            ]),
            'static_info_tables' => serialize([
                'enableManager' => 0,
            ]),
            'theme' =>  serialize([
                'pageLayoutViewEnrichmentFooter' => 1,
            ]),
            't3monitoring_client' => serialize([
                'secret' => 'Provide some secret password',
                'allowedIps' => '2a03:2a00:1100:2::ac10:29bc,172.17.0.1,188.94.251.75',
                'enableDebugForErrors' => 0,
            ]),
            'unroll' => serialize([
                'buttons' => '_savedok,_savedokview,_savedoknew,_saveandclosedok',
                'unroll' => 1,
                'showLabelSave' => 1,
                'showLabelSaveDokView' => 1,
                'showLabelSaveDokNew' => 1,
                'showLabelSaveAndClose' => 1,
                'allowUserSettings' => 0,
            ]),
            'vhs' => serialize([
                'disableAssetHandling' => 1,
            ]),
        ],
    ],
    'FE' => [
        'disableNoCacheParameter' => true,
        'loginSecurityLevel' => 'rsa',
        'versionNumberInFilename' => 'querystring',
        'noPHPscriptInclude' => true,
        'cHashExcludedParameters' => $GLOBALS['TYPO3_CONF_VARS']['FE']['cHashExcludedParameters'] . ', gclid', // see app/vendor/typo3/cms/typo3/sysext/core/Configuration/DefaultConfiguration.php:995ff for default parameters // TODO TYPO3-9 TYPO3-8-7-9 Remove as it was merged into core http://ift.tt/2yy3hkh
//        'cHashOnlyForParameters' => '',
//        'cHashRequiredParameters' => '',
//        'cHashExcludedParametersIfEmpty' => '',
    ],
    'GFX' => [
        'imagefile_ext' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'] . ',eps',
        'processor_allowUpscaling' => false,
    ],
    'MAIL' => [
        'defaultMailFromAddress' => $site['defaultMailFromAddress'],
        'defaultMailFromName' => $site['defaultMailFromName'],
    ],
    'SYS' => [
        'caching' => [
            'cacheConfigurations' => [
                'extbase_object' => [
                    /* @TODO Until an solution is provided by the core https://forge.typo3.org/issues/78140 */
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
        'defaultCategorizedTables' => '',
        'sitename' => htmlspecialchars($site['sitenameBase']) . ' [' . $context . ']',
        'fluid' => [
            'namespaces' => [
                'theme' => [
                    'JosefGlatz\\Theme\\ViewHelpers',
//                    'Sup7even\\ThemeOverride\\ViewHelpers',
                ],
            ],
        ],
        'textfile_ext' => $GLOBALS['TYPO3_CONF_VARS']['SYS']['tsfile_ext'] . ',setupts,constantsts,ts1,tsc',
        'UTF8filesystem' => true,
        'systemLocale' => 'de_DE.utf8',
        'cookieSecure' => 2,
        'productionExceptionHandler' => \JosefGlatz\Theme\Error\ProductionExceptionHandler::class
    ],
];

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$customChanges);

// Logging
if (class_exists(\GeorgRinger\Logging\Log\Monolog\Processor\Typo3Processor::class)) {
    $GLOBALS['TYPO3_CONF_VARS']['MONOLOG'] = [
        'processorConfiguration' => [
            \GeorgRinger\Logging\Log\Monolog\Processor\Typo3Processor::class => [],
        ],
        'handlerConfiguration' => [
            'name' => 'General',
            'handlers' => [
                \Monolog\Handler\StreamHandler::class => [
                    'configuration' => [
                        PATH_site . 'typo3temp/var/logs/general.log',
                        \Monolog\Logger::WARNING,
                    ],
                ],
            ],
        ],
    ];
    $GLOBALS['TYPO3_CONF_VARS']['MONOLOG']['JosefGlatz']['Theme']['Error'] = [
        'processorConfiguration' => [
            \GeorgRinger\Logging\Log\Monolog\Processor\Typo3Processor::class => [],
        ],
        'handlerConfiguration' => [
            'name' => 'Page errors',
            'handlers' => [
                \Monolog\Handler\NativeMailerHandler::class => [
                    'configuration' => [
                        'admin@example.org',
                        'Error from website',
                        'no-reply@example.org',
                        \Monolog\Logger::DEBUG,
                    ],
                ],
                \Monolog\Handler\StreamHandler::class => [
                    'configuration' => [
                        PATH_site . 'typo3temp/var/logs/pageerror.log',
                        \Monolog\Logger::DEBUG,
                    ],
                ],
            ],
        ],
    ];
}

/*
 * include the most general file e.g. "AdditionalConfiguration_Staging.php
 */
$file = realpath(__DIR__) . '/AdditionalConfiguration_' . $contextMainPart . '.php';
if (is_file($file)) {
    /** @noinspection PhpIncludeInspection */
    include_once($file);
    $GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$customChanges);
}

/*
 * check for a more specific configuration as well e.g. "AdditionalConfiguration_Development_Profiling.php"
 */
$file = realpath(__DIR__) . '/AdditionalConfiguration_' . $contextMainPart . '_' . $contextSubPart1 . '.php';
if (is_file($file)) {
    /** @noinspection PhpIncludeInspection */
    include_once($file);
    $GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$customChanges);
}

/*
 * check for a more specific configuration as well, e.g. "AdditionalConfiguration_Production_Live_Server4.php"
 */
$file = realpath(__DIR__) . '/AdditionalConfiguration_' . $contextMainPart . '_' . $contextSubPart1
    . '_' . $contextSubPart2 . '.php';
if (is_file($file)) {
    /** @noinspection PhpIncludeInspection */
    include_once($file);
    $GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$customChanges);
}

/*
 * load custom configuration, that is not placed in git, e.g. for local development only changes
 */
if ($contextMainPart === 'Development') {
    $file = realpath(__DIR__) . '/AdditionalConfiguration_custom.php';
    if (is_file($file)) {
        /** @noinspection PhpIncludeInspection */
        include_once($file);
        $GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$customChanges);
    }
}

/*
 * add composer autoloader
 */
$composerAutoloader = realpath(__DIR__ . '/../../vendor/autoload.php');

if (!empty($composerAutoloader) && is_file($composerAutoloader)) {
    include_once($composerAutoloader);
}
