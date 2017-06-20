<?php
declare(strict_types=1);
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
            't3monitoring_client' => serialize([
                'secret' => 'Provide some secret password',
                'allowedIps' => '2a03:2a00:1100:2::ac10:29bc,172.17.0.1,188.94.251.75',
                'enableDebugForErrors' => 0,
            ]),
            'backend' => serialize([
                'loginLogo' => 'EXT:theme/Resources/Public/Images/Backend/Login/LoginLogo.svg',
                'loginHighlightColor' => '#ff8700',
                'loginBackgroundImage' => 'EXT:theme/Resources/Public/Images/Backend/Login/Background.png',
                'backendLogo' => 'EXT:theme/Resources/Public/Images/Backend/' . $site['backendLogo'] . '.svg', // custom backend logo should not by higher than 37px
                // @TODO: Backend Logo (Stage, Prod, Dev)
                'backendFavicon' => 'EXT:backend/Resources/Public/Icons/favicon.ico',
                // @TODO: Backend FavIcon (Stage, Prod, Dev)
            ]),
            'fluid_styled_content' => serialize([
                'loadContentElementWizardTsConfig' => 1,
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
            'rtehtmlarea' => serialize([
                'defaultConfiguration' => 'Minimal',
                'enableInlineElements' => 0,
                'allowStyleAttribute' => 0,
                'enableAccessibilityIcons' => 0,
                'forceCommandMode' => 0,
                'noSpellCheckLanguages' => 'ja,km,ko,lo,th,zh,b5,gb',
                'AspellDirectory' => '/usr/bin/aspell',
            ]),
            'rx_shariff' => serialize([
                'services' => 'GooglePlus, Facebook, LinkedIn, Reddit, StumbleUpon, Flattr, Pinterest, Xing, AddThis',
                'allowedDomains' => 'SERVER_NAME',
                'ttl' => 3600,
                'facebook_app_id' => '',
                'facebook_secret' => '',
            ]),
            'lfeditor' => serialize([
                'viewLanguages' => '', // cz,de,fr,hr,hu,it,nl,pl,ru,sk
                'defaultLanguage' => '',
                'extIgnore' => '/^(CVS|.svn|.git|csh_)/',
                'changeXlfDate' => 1,
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
        ],
    ],
    'FE' => [
        'disableNoCacheParameter' => true,
        'loginSecurityLevel' => 'rsa',
        'versionNumberInFilename' => 'querystring',
        'noPHPscriptInclude' => true,
        'cHashExcludedParameters' => $GLOBALS['TYPO3_CONF_VARS']['FE']['cHashExcludedParameters'] . '', // see app/vendor/typo3/cms/typo3/sysext/core/Configuration/DefaultConfiguration.php:995ff for default parameters
//        'cHashOnlyForParameters' => '',
//        'cHashRequiredParameters' => '',
//        'cHashExcludedParametersIfEmpty' => '',
    ],
    'GFX' => [
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
    ],
];

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$customChanges);

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
