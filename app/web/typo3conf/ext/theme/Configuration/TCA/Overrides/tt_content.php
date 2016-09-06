<?php
defined('TYPO3_MODE') || die('Access denied.');

// set predefined image crop ratios

// add ratios
$GLOBALS['TCA']['sys_file_reference']['columns']['crop']['config']['ratios'] = [
    '1.5' => '3 x 2',
    '1.333333333' => '4 x 3',
    'NaN' => 'LLL:EXT:lang/locallang_wizards.xlf:imwizard.ratio.free',
];
