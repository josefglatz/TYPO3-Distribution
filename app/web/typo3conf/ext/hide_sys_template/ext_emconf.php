<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Hide sys_template in backend',
    'description' => 'Make sys_template records vanish everywhere',
    'category' => 'Backend',
    'author' => 'Josef Glatz',
    'author_email' => 'jousch@gmail.com',
    'author_company' => 'https://jousch.com',
    'state' => 'stable',
    'clearCacheOnLoad' => 1,
    'version' => '1.0.0',
    'constraints' =>
        [
            'depends' =>
                [
                    'typo3' => '9.5.0-9.5.99',
                ],
        ],
    'autoload' =>
        [
            'psr-4' =>
                [
                    'JosefGlatz\\HideSysTemplate\\' => 'Classes',
                ],
        ],
];
