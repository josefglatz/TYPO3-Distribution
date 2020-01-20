<?php
declare(strict_types=1);

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], [
    'BE' => [
        'debug'   => true,
    ],
]);
