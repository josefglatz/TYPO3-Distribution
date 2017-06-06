<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Project specific theme extension',
    'description' => 'Sitepackage/Theme/Extension of this great website.',
    'category' => 'Theme',
    'author' => 'Josef Glatz',
    'author_email' => 'jousch@jousch.com',
    'author_company' => 'http://jousch.com',
    'state' => 'excludeFromUpdates',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'version' => '0.0.0',
    'constraints' =>
        [
            'depends' =>
                [
                    'typo3' => '8.7.1-8.7.99',
                ],
            'conflicts' =>
                [
                    'css_styled_content' => '',
                ],
            'suggests' =>
                [
                    'autoswitchtolistview' => '',
                    'be_secure_pw' => '',
                    'blog' => '',
                    'dd_googlesitemap' => '',
                    'extractor' => '',
                    'felogin' => '',
                    'fluid_styled_content' => '',
                    'form' => '',
                    'formhandler' => '',
                    'gridelements' => '',
                    'image_autoresize' => '',
                    'in2publish_core' => '',
                    'lfeditor' => '',
                    'linkvalidator' => '',
                    'logging' => '',
                    'my_redirects' => '',
                    'news' => '',
                    'page_speed' => '',
                    'piwik' => '',
                    'powermail' => '',
                    'realurl' => '',
                    'rx_shariff' => '',
                    'scheduler' => '',
                    'seo_basics' => '',
                    'solr' => '',
                    'sourceopt' => '',
                    'sr_language_menu' => '',
                    'static_info_tables' => '',
                    't3monitoring_client' => '',
                    'transladder' => '',
                    'tt_address' => '',
                    'typoscript_rendering' => '',
                    'vhs' => '',
                    'yag' => '',
                    'yaml_configuration' => '',
                ],
        ],
    'autoload' =>
        [
            'psr-4' =>
                [
                    'JosefGlatz\\Theme\\' => 'Classes',
                ],
        ],
    'autoload-dev' =>
        [
            'psr-4' =>
                [
                    'JosefGlatz\\Theme\\Tests\\' => 'Tests',
                ],
        ],
];
