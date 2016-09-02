<?php
$EM_CONF[$_EXTKEY] = array(
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
        array(
            'depends' =>
                array(
                    'typo3' => '8.3.0-8.99.99',
                ),
            'conflicts' =>
                array(
                ),
            'suggests' =>
                array(
                ),
        ),
    'autoload' =>
        array(
            'psr-4' =>
                array(
                    'Sup7even\\Theme\\' => 'Classes',
                ),
        ),
    'autoload-dev' =>
        array(
            'psr-4' =>
                array(
                    'Sup7even\\Theme\\Tests\\' => 'Tests',
                ),
        ),
);
