<?php declare(strict_types=1);
/*
* This file is part of the TYPO3 CMS project.
*
* It is free software; you can redistribute it and/or modify it under
* the terms of the GNU General Public License, either version 2
* of the License, or any later version.
*
* For the full copyright and license information, please read the
* LICENSE.txt file that was distributed with this source code.
*
* The TYPO3 project - inspiring people to share!
*/

/**
 * This is a boilerplate of typo3conf/AdditionalFactoryConfiguration.php.
 * It is used as override file during installation and overrides/extends
 * defaults from EXT:core/Configuration/FactoryConfiguration.php.
 */
return [
    'EXTCONF' => [
        'lang' => [
            'availableLanguages' => [
                'de',
            ],
        ],
    ],
    'GFX' => [
        // Override default quality for processed images
        'jpg_quality' => '86',
        'processor_allowUpscaling' => false,
    ],
    'SYS' => [
        'sitename' => 'TYPO3 Distribution',
    ],
];
