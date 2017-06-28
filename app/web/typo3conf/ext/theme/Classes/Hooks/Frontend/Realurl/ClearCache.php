<?php

declare(strict_types=1);

/**
 * This file is part of the "theme" Extension which is part of
 * the jousch/TYPO3-Distribution for TYPO3 CMS.
 */

namespace JosefGlatz\Theme\Hooks\Frontend\Realurl;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

class ClearCache
{
    /**
     * Delete RealUrl AutoConf file.
     *
     * Clears automatic configuration. Note: we do not check if
     * the real url automatic configuration is enabled.
     * Even it's disabled actually, later it can be re-enabled
     * and suddenly an obsolete config will be used. So we clear always.
     *
     * Based on the idea of \DmitryDulepov\Realurl\Hooks\DataHandler::clearAutoConfiguration
     *
     * @return void
     */
    public function deleteAutoConfigurationFile()
    {
        if (ExtensionManagementUtility::isLoaded('realurl') && file_exists(PATH_site.TX_REALURL_AUTOCONF_FILE)) {
            @unlink(PATH_site.TX_REALURL_AUTOCONF_FILE);
        }
    }
}
