<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:theme/Resources/Private/Language/locallang_db.xlf:tx_theme_facts_figures',
        'label' => 'label',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' =>
            [
                'disabled' => 'hidden',
                'starttime' => 'starttime',
                'endtime' => 'endtime',
            ],
        'searchFields' => 'label,value,icon,link',
        'dynamicConfigFile' => '',
        'typeicon_classes' => [
            'default' => 'theme-content-facts-figures'
        ],
        'hideTable' => true,
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden, label, value, icon, link, sys_language_uid, l10n_parent, l10n_diffsource',
    ],
    'types' => [
        1 => [
            'showitem' => 'sys_language_uid,l10n_parent,l10n_diffsource,hidden,label,value,icon,link,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,starttime,endtime',
        ],
    ],
    'palettes' => [

    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'sys_language',
                'foreign_table_where' => 'ORDER BY sys_language.title',
                'items' => [
                    0 => [
                        0 => 'LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages',
                        1 => -1,
                    ],
                    1 => [
                        0 => 'LLL:EXT:lang/locallang_general.xlf:LGL.default_value',
                        1 => 0,
                    ],
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    0 => [
                        0 => '',
                        1 => 0,
                    ],
                ],
                'foreign_table' => 'tx_theme_facts_figures',
                'foreign_table_where' => 'AND tx_theme_facts_figures.pid=###CURRENT_PID### AND tx_theme_facts_figures.sys_language_uid IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'starttime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => [
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'renderType' => 'inputDateTime',
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => [
                    'lower' => 1502143200,
                ],
            ],
        ],
        'endtime' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => [
                'behaviour' => [
                    'allowLanguageSynchronization' => true,
                ],
                'renderType' => 'inputDateTime',
                'type' => 'input',
                'size' => 13,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => [
                    'lower' => 1502143200,
                ],
            ],
        ],
        'parentid' => [
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    0 => [
                        0 => '',
                        1 => 0,
                    ],
                ],
                'foreign_table' => 'tt_content',
                'foreign_table_where' => 'AND tt_content.pid=###CURRENT_PID### AND tt_content.sys_language_uid IN (-1,###REC_FIELD_sys_language_uid###)',
            ],
        ],
        'parenttable' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'sorting' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'label' => [
            'config' => [
                'type' => 'input',
                'eval' => 'required',
            ],
            'exclude' => '1',
            'label' => 'LLL:EXT:theme/Resources/Private/Language/locallang_db.xlf:tx_theme_facts_figures.label',
        ],
        'value' => [
            'config' => [
                'type' => 'input',
                'eval' => 'required',
                'placeholder' => '1234',
            ],
            'exclude' => '1',
            'label' => 'LLL:EXT:theme/Resources/Private/Language/locallang_db.xlf:tx_theme_facts_figures.value',
        ],
        'icon' => [
            'config' => [
                'type' => 'inline',
                'foreign_table' => 'sys_file_reference',
                'foreign_field' => 'uid_foreign',
                'foreign_sortby' => 'sorting_foreign',
                'foreign_table_field' => 'tablenames',
                'foreign_match_fields' => [
                    'fieldname' => 'icon',
                ],
                'foreign_label' => 'uid_local',
                'foreign_selector' => 'uid_local',
                'overrideChildTca' => [
                    'columns' => [
                        'uid_local' => [
                            'config' => [
                                'appearance' => [
                                    'elementBrowserType' => 'file',
                                    'elementBrowserAllowed' => 'svg',
                                ],
                            ],
                        ],
                    ],
                    'types' => [
                        0 => [
                            'showitem' => '--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette, --palette--;;filePalette',
                        ],
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                            'showitem' => '
                                alternative,--linebreak--,
                                --palette--;;filePalette'
                        ],
                    ],
                ],
                'filter' => [
                    0 => [
                        'userFunc' => 'TYPO3\\CMS\\Core\\Resource\\Filter\\FileExtensionFilter->filterInlineChildren',
                    ],
                ],
                'appearance' => [
                    'headerThumbnail' => [
                        'field' => 'uid_local',
                        'width' => '45',
                        'height' => '45c',
                    ],
                    'enabledControls' => [
                        'info' => 'icon',
                        'dragdrop' => 'icon',
                        'hide' => 'icon',
                        'delete' => 'icon',
                    ],
                    'fileUploadAllowed' => 'false',
                ],
                'behaviour' => [
                    'localizeChildrenAtParentLocalization' => 'icon',
                ],
                'minitems' => '1',
                'maxitems' => '1',
            ],
            'exclude' => '1',
            'l10n_mode' => 'copy',
            'label' => 'LLL:EXT:theme/Resources/Private/Language/locallang_db.xlf:tx_theme_facts_figures.icon',
        ],
        'link' => [
            'config' => [
                'type' => 'input',
                'renderType' => 'inputLink',
                'softref' => 'typolink',
                'fieldControl' => [
                    'linkPopup' => [
                        'options' => [
                            'title' => 'Link',
                            'windowOpenParameters' => 'height=300,width=500,status=0,menubar=0,scrollbars=1',
                            'blindLinkOptions' => 'folder,url',
                        ],
                    ],
                ],
            ],
            'exclude' => '1',
            'label' => 'LLL:EXT:theme/Resources/Private/Language/locallang_db.xlf:tx_theme_facts_figures.link',
        ],
    ],
];
