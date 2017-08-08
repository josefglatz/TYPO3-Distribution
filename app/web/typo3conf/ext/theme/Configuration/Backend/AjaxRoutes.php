<?php
/**
 * Definitions for routes provided by EXT:theme
 * Contains all AJAX-based routes for entry points provided by EXT:theme
 */
return [
    'theme_realurl_deleteautoconf' => [
        'path' => '/theme/realurl/deleteautoconf',
        'target' => \JosefGlatz\Theme\Hooks\Frontend\Realurl\ClearCache::class . '::deleteAutoConfigurationFile',
        'parameters' => [
        ]
    ],
    'theme_clear_processedfiles' => [
        'path' => '/theme/clear/processedfiles',
        'target' => \JosefGlatz\Theme\Hooks\Backend\Toolbar\ClearProcessedFilesMenuItem::class . '::clearProcessedFiles',
        'parameters' => [
        ]
    ],
];
