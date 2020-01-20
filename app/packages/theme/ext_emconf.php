<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Base sitepackage',
    'description' => 'Base sitepackage of another great website.',
    'category' => 'Theme',
    'author' => 'Josef Glatz',
    'author_email' => 'josefglatz@gmail.com',
    'state' => 'excludeFromUpdates',
    'clearCacheOnLoad' => true,
    'version' => '9.5.0',
    'constraints' =>
        [
            'depends' =>
                [
                    'hide_sys_template' => '',
                    'typo3' => '9.5.0-9.5.99',
                ],
            'conflicts' =>
                [
                    'rsaauth' => '',
                ],
            'suggests' =>
                [
                    'autoswitchtolistview' => '',
                    'be_secure_pw' => '',
                    'benefits' => '',
                    'begroups_roles' => '',
                    'beuser_fastswitch' => '',
                    'blog' => '',
                    'content_defender' => '',
                    'crontab' => '',
                    'cropvariantsbuilder' => '',
                    'extractor' => '',
                    'felogin' => '',
                    'fluid_styled_content' => '',
                    'fluid_styled_responsive_images' => '',
                    'form' => '',
                    'formhandler' => '',
                    'gdpr' => '',
                    'gravatar' => '',
                    'iconcheck' => '',
                    'gridelements' => '',
                    'image_autoresize' => '',
                    'in2publish_core' => '',
                    'infogram' => '',
                    'lfeditor' => '',
                    'linkvalidator' => '',
                    'maildebug' => '',
                    'maps2' => '',
                    'mask' => '',
                    'mask_export' => '',
                    'mess_detector' => '',
                    'my_redirects' => '',
                    'news' => '',
                    'news_gallery' => '',
                    'page_speed' => '',
                    'querybuilder' => '',
                    'rte_ckeditor' => '',
                    'rx_shariff' => '',
                    'scheduler' => '',
                    'seo' => '',
                    'seo_basics' => '',
                    'seo_aspect_ratios' => '',
                    'solr' => '',
                    'sourceopt' => '',
                    'sr_language_menu' => '',
                    'static_info_tables' => '',
                    't3monitoring_client' => '',
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
