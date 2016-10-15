<?php
namespace JosefGlatz\Theme\Hooks\Frontend\Realurl;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
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
        if (ExtensionManagementUtility::isLoaded('realurl') && file_exists(PATH_site . TX_REALURL_AUTOCONF_FILE)) {
            @unlink(PATH_site . TX_REALURL_AUTOCONF_FILE);
        }
    }
}
