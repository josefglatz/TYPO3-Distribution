#!/usr/bin/env php
<?php
declare(strict_types = 1);

use Symfony\Component\VarExporter\VarExporter;

include_once __DIR__ . '/../app/vendor/autoload.php';

// Resolve absolute path to LocalConfiguration.php
$file = implode(
    DIRECTORY_SEPARATOR,
    [ dirname(realpath(__DIR__)), 'app', 'private', 'typo3conf', 'LocalConfiguration.php' ]
);

// Exit if LocalConfiguration.php already exists
if (is_file($file) && !in_array('-f', $_SERVER['argv'])) {
    exit(0);
}

// Minimal configuration with an encryption key and a dummy install tool password
$encryptionKey = getenv('TYPO3_ENCRYPTION_KEY') ?: bin2hex(random_bytes(48));
$config = [
    'BE' => [
        'installToolPassword' => password_hash(base64_encode(hash('sha384', 'joh316', true)), PASSWORD_ARGON2I, [
            'cost' => 12,
        ]),
        'loginSecurityLevel' => 'normal',
    ],
    'SYS' => [
        'encryptionKey' => $encryptionKey,
        'exceptionalErrors' => E_ALL & ~(E_STRICT | E_NOTICE | E_DEPRECATED | E_USER_DEPRECATED),
    ],
    'FE' => [
        'trustedHostsPattern' => '.*',
    ],
];

// Write the file
$dir = dirname($file);
$code = sprintf("<?php\nreturn %s;\n", VarExporter::export($config));

// Create dir if it doesn't exists
if (!is_dir($dir)) {
    @mkdir(dirname($file), 2770, true);
}

// Create the file and set permissions
file_put_contents($file, $code);
chmod($file, 0660);
