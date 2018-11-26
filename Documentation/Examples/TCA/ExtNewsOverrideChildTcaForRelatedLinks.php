<?php

$tca = [
    'columns' => [
        // override related_links IRRE
        'related_links' => [
            'config' => [
                'overrideChildTca' => [
                    'types' => [
                        0 => [
                            // remove description field by modifying showitem value
                            'showitem' => 'uri, --palette--;;paletteCore,title'
                        ],
                    ],
                ],
            ],
        ],
    ],
];
$GLOBALS['TCA']['tx_news_domain_model_news'] = array_replace_recursive($GLOBALS['TCA']['tx_news_domain_model_news'], $tca);
