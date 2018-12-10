<?php
defined('TYPO3_MODE') || die('Access denied.');

// set instance values
$site = [
    'sitenameBase' => 'TYPO3 Distribution',
    'defaultMailFromAddress' => 'no-reply@example.at',
    'defaultMailFromName' => 'TYPO3 Distribution',
    'defaultMailReplyToAddress' => 'office@example.at',
    'defaultMailReplyToName' => 'TYPO3 Distribution',
    'backendLogo' => 'BackendLogo',
];

// get complete context
$context = \TYPO3\CMS\Core\Utility\GeneralUtility::getApplicationContext()->__toString();

if ($context) {
    // check for "Production/Live/Server123" etc
    [$contextMainPart, $contextSubPart1, $contextSubPart2] = explode('/', $context);

    // set context specific TYPO3 backend logo
    if (TYPO3_MODE === 'BE') {
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
    }
}

// project specific configuration
$customChanges = [
    'BE' => [
        'explicitADmode' => 'explicitAllow',
        'loginSecurityLevel' => 'normal',
        'notificationPrefix' => '[' . htmlspecialchars($site['sitenameBase']) . ' TYPO3 Note]',
    ],
    'DB' => [
        'Connections' => [
            'Default' => [
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
            'backendLogo' => 'EXT:theme/Resources/Public/Images/Backend/' . $site['backendLogo'] . '.svg', // custom backend logo should not by higher than 37px
            // @TODO: Backend Logo (Stage, Prod, Dev)
            'backendFavicon' => 'EXT:backend/Resources/Public/Icons/favicon.ico',
            // @TODO: Backend FavIcon (Stage, Prod, Dev)
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
        'beuser_fastswitch' => [
            'allowedUserNamePattern' => '',
            'allowedUserEmailAddressPattern' => '',
            'allowedUserGroupUids' => '',
            'allowedUserGroupNamePattern' => '',
            'showAdminUsers' => 0,
            'activeSearchbox' => 0,
            'defaultListing' => 'default',
        ],
        'extractor' => [
            'auto_extract' => 0,
            'enable_php' => 1,
            'enable_tika' => 0,
            'enable_tools_exiftool' => 0,
            'enable_tools_pdfinfo' => 0,
            'mapping_base_directory' => 'EXT:extractor/Configuration/Services/',
            'mapping_configuration' => '',
            'tika_jar_path' => '',
            'tika_mode' => 'jar',
            'tika_server_host' => '',
            'tika_server_port' => 9998,
            'tools_exiftool' => '',
            'tools_pdfinfo' => '',
        ],
        'extensionmanager' => [
            'automaticInstallation' => 1,
            'offlineMode' => 0,
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
            'forceProvider' => false, // Use Gravatar service even if email address is empty: Normally the Gravatar service is only requested when a email address is set. With this setting you can also enable is for BE users without email address. The above fallback will always be used then.
            'useProxy' => true, // Improve privacy by proxying the image request
        ],
        'iconcheck' => [
            'listAllIconIdentifiers' => 1,
            'listIconsWithPrefix' => 'theme-backend, theme-belayout, theme-content, content, apps-pagetree',
            'enableModuleForEverybody' => 0,
            'disableModule' => 0,
        ],
        'image_autoresize_ff' => [
            'directories' => 'fileadmin/,uploads/',
            'file_types' => 'jpg,jpeg,png',
            'threshold' => '400K',
            'max_width' => 1024,
            'max_height' => 768,
            'auto_orient' => 1,
            'conversion_mapping' => 'ai => jpg,bmp => jpg,pcx => jpg,tga => jpg,tif => jpg,tiff => jpg',
            'keep_metadata' => 0,
            'resize_png_with_alpha' => 0,
        ],
        'lfeditor' => [
            'viewLanguages' => '', // cz,de,fr,hr,hu,it,nl,pl,ru,sk
            'defaultLanguage' => '',
            'extIgnore' => '/^(CVS|.svn|.git|csh_)/',
            'changeXlfDate' => 1,
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
        'mask_export' => [
            'contentElementIcons' => 1,    // If enabled the export includes icons for content elements.
            'backendPreview' => 1,         // If enabled the export contains some PHP and Fluid files to show a record preview in the page layout.
        ],
        'news' => [
            'archiveDate' => 'date',
            'rteForTeaser' => 0,
            'tagPid' => 1,
            'prependAtCopy' => 0,
            'categoryRestriction' => 'none',
            'categoryBeGroupTceFormsRestriction' => 0,
            'contentElementRelation' => 1,
            'manualSorting' => 0,
            'dateTimeNotRequired' => 0,
            'showAdministrationModule' => 1,
            'showImporter' => 0,
            'storageUidImporter' => '1',
            'resourceFolderImporter' => '/news_import',
        ],
        'page_speed' => [
            'key' => '',
            'cacheTime' => 86400,
            'demo' => 1,
        ],
        'powermail' => [
            'disableIpLog' => 0,
            'disableMarketingInformation' => 1,
            'disableBackendModule' => 0,
            'disablePluginInformation' => 0,
            'disablePluginInformationMailPreview' => 0,
            'enableCaching' => 0,
            'l10n_mode_merge' => 0,
            'replaceIrreWithElementBrowser' => 0
        ],
        'rx_shariff' => [
            'services' => 'GooglePlus, Facebook, LinkedIn, Reddit, StumbleUpon, Flattr, Pinterest, Xing, AddThis',
            'allowedDomains' => 'SERVER_NAME',
            'ttl' => 3600,
            'facebook_app_id' => '',
            'facebook_secret' => '',
        ],
        'saltedpasswords' => [
            'BE.' => [
                'saltedPWHashingMethod' => \TYPO3\CMS\Saltedpasswords\Salt\Pbkdf2Salt::class, // Default since 8-7 (for legacy reasons still here)
            ],
            'FE.' => [
                'enabled' => 1,
                'saltedPWHashingMethod' => \TYPO3\CMS\Saltedpasswords\Salt\Pbkdf2Salt::class, // Default since 8-7 (for legacy reasons still here)
            ],
        ],
        'scheduler' => [
            'maxLifetime' => 1440,
            'showSampleTasks' => 0,
        ],
        'static_info_tables' => [
            'enableManager' => 0,
        ],
        'staticfilecache' => [
            'clearCacheForAllDomains' => 1,
            'sendCacheControlHeader' => 1,
            'sendCacheControlHeaderRedirectAfterCacheTimeout' => 0,
            'sendTypo3Headers' => 0,
            'enableStaticFileCompression' => 1,
            'showGenerationSignature' => 1,
            'fileTypes' => 'xml,rss',
            'strftime' => '%d-%m-%y %H:%M',
            'recreateURI' => 0,
            'boostMode' => 0,
            'backendDisplayMode' => 'current',
            'disableInDevelopment' => 1,
            'htaccessTemplateName' => 'EXT:staticfilecache/Resources/Private/Templates/Htaccess.html',
            'saveCacheHook' => 'InsertPageIncache'
        ],
        'theme' =>  [
            'pageLayoutViewEnrichmentFooter' => 1,
        ],
        't3monitoring_client' => [
            'secret' => 'Provide some secret password',
            'allowedIps' => '2a03:2a00:1100:2::ac10:29bc,172.17.0.1,188.94.251.75',
            'enableDebugForErrors' => 0,
        ],
        'vhs' => [
            'disableAssetHandling' => 1,
        ],
    ],
    'FE' => [
        'disableNoCacheParameter' => true,
        'loginSecurityLevel' => 'normal',
        'versionNumberInFilename' => 'querystring',
        'noPHPscriptInclude' => true,
    ],
    'GFX' => [
        'imagefile_ext' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'] . ',eps',
        'processor_allowUpscaling' => false,
    ],
    'MAIL' => [
        'defaultMailFromAddress' => $site['defaultMailFromAddress'],
        'defaultMailFromName' => $site['defaultMailFromName'],
        'defaultMailReplyToAddress' => $site['defaultMailReplyToAddress'],
        'defaultMailReplyToName' => $site['defaultMailReplyToName'],
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
        'fal' => [
            'registeredCollections' => [
                'tx_theme_images' => \TYPO3\CMS\Core\Resource\Collection\StaticFileCollection::class,
            ],
        ],
        'fluid' => [
            'namespaces' => [
                'theme' => [
                    'JosefGlatz\\Theme\\ViewHelpers',
//                    'JosefGlatz\\ThemeProject\\ViewHelpers',
                ],
            ],
        ],
        'UTF8filesystem' => true,
        'systemLocale' => 'de_DE.utf8',
        'cookieSecure' => 2,
        'productionExceptionHandler' => \JosefGlatz\Theme\Error\ProductionExceptionHandler::class,
        'features' => [
            'unifiedPageTranslationHandling' => true
        ],
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

// Load application context specific additional configuration
if ($context) {
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
}
