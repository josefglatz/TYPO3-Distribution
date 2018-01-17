<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class Tca
 *
 * this class moves items in a showitem string to a specific position
 *
 * = Example
 *
 * $GLOBALS['TCA']['pages']['types']['4']['showitem'] =
 *      JosefGlatz\Theme\Utility\Tca::moveShowitemItems(
 *          $GLOBALS['TCA']['pages']['types']['4']['showitem'],
 *          '--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.shortcut;shortcut',
 *          2
 *      );
 */
class Tca
{
    /**
     * @param string $showitem Existing showitem string
     * @param string $value String which should repositioned
     * @param int $finalPosition Final position of $value
     * @return string Return final string
     */
    public static function moveShowitemItems(string $showitem, string $value, int $finalPosition): string
    {
        $showitem = GeneralUtility::trimExplode(',', $showitem, true);
        $key = array_search(trim($value), array_map('trim', $showitem), true);
        $insert = $showitem[$key];
        unset($showitem[$key]);
        array_splice($showitem, $finalPosition, 0, $insert);
        return implode(',', $showitem);
    }
}
