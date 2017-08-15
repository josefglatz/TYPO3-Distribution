<?php
/**
 * This file is part of the TYPO3 CMS distribution "jousch/TYPO3-Distribution".
 *
 *
 */
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey, $table) {

        $tca = [
            'columns' => [
                'link' => [
                    'config' => [
                        'fieldControl' => [
                            'linkPopup' => [
                                'options' => [
                                    'blindLinkFields' => 'class'
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'types' => [
            ],
        ];
        $GLOBALS['TCA'][$table] = array_replace_recursive($GLOBALS['TCA'][$table], $tca);
    },
    'theme',
    'sys_file_reference'
);
