<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Project specific theme extension',
    'description' => 'Description for ext',
    'category' => 'Theme',
    'author' => 'Josef Glatz, Josef Glatz',
    'author_email' => 'jousch@jousch.com, j.glatz@supseven.at',
    'author_company' => 'http://jousch.com, http://www.sup7even.digital',
    'shy' => '',
    'priority' => '',
    'module' => '',
    'state' => 'excludeFromUpdates',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 0,
    'lockType' => '',
    'version' => '0.0.0',
    'constraints' =>
        [
            'depends' =>
                [
                    'typo3' => '8.3.0-8.99.99',
                ],
            'conflicts' =>
                [
                ],
            'suggests' =>
                [
                    'realurl' => '',
                    'news' => '',
                    'piwik' => '',
                    'gridelements' => '',
                    'tt_address' => '',
                ],
        ],
    'autoload' =>
        [
            'psr-4' =>
                [
                    'Sup7even\\Theme\\' => 'Classes',
                ],
        ],
    'autoload-dev' =>
        [
            'psr-4' =>
                [
                    'Sup7even\\Theme\\Tests\\' => 'Tests',
                ],
        ],
];
