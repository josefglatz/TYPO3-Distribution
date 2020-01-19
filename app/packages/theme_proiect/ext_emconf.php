<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Project sitepackage',
    'description' => 'Project specific sitepackage of this great website.',
    'category' => 'Theme',
    'author' => 'Josef Glatz',
    'author_email' => 'jousch@gmail.com',
    'author_company' => 'https://jousch.com',
    'state' => 'excludeFromUpdates',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'version' => '0.0.0',
    'constraints' =>
        [
            'depends' =>
                [
                    'typo3' => '9.5.0-9.5.99',
                    'theme' => '',
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
