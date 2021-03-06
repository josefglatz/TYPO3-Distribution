<?php
declare(strict_types = 1);

namespace JosefGlatz\Theme\Hooks\Frontend;

class TypoScriptHook
{

    /**
     * Configuration for the various possible TS entry points
     * Key = page id
     *
     * @var array
     */
    protected $configuration = [
        1 => [
            'path' => 'SiteDefault',
            'title' => 'Default Theme',
            'sitetitle' => 'The TYPO3 Distribution',
            'uid' => 'theme_default'
        ]
    ];

    /**
     * Hooks into TemplateService to load the default TS
     *
     * This hook is used as an alternative to a sys_template record within the database.
     *
     * @param array $parameters
     * @param \TYPO3\CMS\Core\TypoScript\TemplateService $parentObject
     */
    public function addCustomTypoScriptTemplate($parameters, $parentObject)
    {
        // Disable the inclusion of default TypoScript set via TYPO3_CONF_VARS
        //$parameters['isDefaultTypoScriptAdded'] = true;
        // Disable the inclusion of ext_typoscript_setup.txt of all extensions
        //$parameters['processExtensionStatics'] = false;

        // No template was found in rootline so far, so a custom "fake" sys_template record is added
        if ($parentObject->outermostRootlineIndexWithTemplate === 0) {
            if (is_array($parameters['rootLine']) && !empty($parameters['rootLine'])) {
                $rootPage = $parameters['rootLine'][0];
                $rootPageId = (int)$rootPage['uid'];
                foreach ($this->configuration as $configurationPageId => $configuration) {
                    if ($configurationPageId !== $rootPageId) {
                        continue;
                    }
                    $path = 'EXT:theme/Configuration/TypoScript/Sites/' . $configuration['path'] . '/';
                    $row = [
                        'config' => '@import \'' . $path . 'setup.typoscript\'',
                        'constants' => '@import \'' . $path . 'constants.typoscript\'',
                        'nextLevel' => 0,
                        'static_file_mode' => 3,
                        'uid' => $configuration['uid'],
                        'title' => $configuration['title'],
                        'sitetitle' => $configuration['sitetitle'],
                    ];
                    $parentObject->processTemplate($row, 'sys_' . $row['uid'], $configurationPageId, 'sys_' . $row['uid']);
                }
            }
        }
        if (!$parentObject->rootId) {
            $parentObject->rootId = 1;
        }
    }
}
