<?php
declare(strict_types=1);

// Override configuration of LocalConfiguration
$customChanges = [
    'GFX' => [
        'processor' => 'GraphicsMagick',
        'processor_allowTemporaryMasksAsPng' => false,
        'processor_colorspace' => 'RGB',
        'processor_effects' => -1,
        'processor_enabled' => true,
        'processor_path' => '/usr/bin/',
        'processor_path_lzw' => '/usr/bin/',
    ],
    // Configuration for mailhog container (running as "mail" docker container)
    'MAIL' => [
        'transport' => 'smtp',
        'transport_smtp_encrypt' => '',
        'transport_smtp_password' => '',
        'transport_smtp_server' => 'mail:1025',
        'transport_smtp_username' => '',
    ],
];

$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], $customChanges);
