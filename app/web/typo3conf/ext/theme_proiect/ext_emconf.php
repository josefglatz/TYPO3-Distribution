<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Project specific theme modification extension',
    'description' => 'Sitepackage-/Theme-/Modification-Extension of this great website.',
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
                ],
            'suggests' =>
                [
                ],
        ],
    'autoload' =>
        [
            'psr-4' =>
                [
                    'JosefGlatz\\ThemeProject\\' => 'Classes',
                ],
        ],
    'autoload-dev' =>
        [
            'psr-4' =>
                [
                    'JosefGlatz\\ThemeProject\\Tests\\' => 'Tests',
                ],
        ],
];
