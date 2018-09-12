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
                    'rtehtmlarea' => '',
                ],
            'suggests' =>
                [
                    'autoswitchtolistview' => '',
                    'backend_debug' => '',
                    'be_secure_pw' => '',
                    'benefits' => '',
                    'begroups_roles' => '',
                    'beuser_fastswitch' => '',
                    'blog' => '',
                    'content_defender' => '',
                    'dd_googlesitemap' => '',
                    'deprecationloganalyzer' => '',
                    'extractor' => '',
                    'felogin' => '',
                    'fluid_styled_content' => '',
                    'fluid_styled_responsive_images' => '',
                    'form' => '',
                    'formhandler' => '',
                    'gravatar' => '',
                    'iconcheck' => '',
                    'gridelements' => '',
                    'image_autoresize' => '',
                    'in2publish_core' => '',
                    'infogram' => '',
                    'lfeditor' => '',
                    'linkvalidator' => '',
                    'logging' => '',
                    'maildebug' => '',
                    'maps2' => '',
                    'mask' => '',
                    'mask_export' => '',
                    'mess_detector' => '',
                    'my_redirects' => '',
                    'news' => '',
                    'news_gallery' => '',
                    'page_speed' => '',
                    'powermail' => '',
                    'querybuilder' => '',
                    'realurl' => '',
                    'realurlconflicts' => '',
                    'rte_ckeditor' => '',
                    'rx_shariff' => '',
                    'scheduler' => '',
                    'seo_basics' => '',
                    'solr' => '',
                    'sourceopt' => '',
                    'sr_language_menu' => '',
                    'static_info_tables' => '',
                    't3monitoring_client' => '',
                    'theme_project' => '',
                    'transladder' => '',
                    'tt_address' => '',
                    'typoscript_rendering' => '',
                    'unlocalizedcrop' => '',
                    'unroll' => '',
                    'vhs' => '',
                    'yaml_configuration' => '',
                    'yoast_seo' => '',
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
