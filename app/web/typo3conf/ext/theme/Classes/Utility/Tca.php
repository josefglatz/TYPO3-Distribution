<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Utility;

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class Tca
 */
class Tca
{
    /**
     * Variables are used to create the defaults in custom ctype showitem configuration
     *
     * @var array
     */
    protected static $showitemDefaults = [
        1 => '
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,
        ',
        2 => '
            --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,
                --palette--;;language,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,
                --palette--;;hidden,
                --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,
                categories,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,
                rowDescription,
            --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended,
        '
    ];

    /**
     * Move items in a showitem string to a specific position
     *
     * = Example
     *
     * $GLOBALS['TCA']['pages']['types']['4']['showitem'] =
     *      JosefGlatz\Theme\Utility\Tca::moveShowitemItems(
     *          $GLOBALS['TCA']['pages']['types']['4']['showitem'],
     *          '--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_tca.xlf:pages.palettes.shortcut;shortcut',
     *          2
     *      );
     *
     * @param string $showitem Existing showitem string
     * @param string $value String which should repositioned
     * @param int $finalPosition Final position of $value
     * @return string Return final string
     */
    public static function moveShowitemItems(string $showitem, string $value, int $finalPosition): string
    {
        $showitemArray = GeneralUtility::trimExplode(',', $showitem, true);
        $key = array_search(trim($value), array_map('trim', $showitemArray), true);
        $insert = $showitemArray[$key];
        unset($showitemArray[$key]);
        array_splice($showitemArray, $finalPosition, 0, $insert);
        return implode(',', $showitemArray);
    }

    /**
     * Retrieve a common specific showitem part
     *
     * @param int $index
     * @return string
     */
    public static function getShowitemDefault(int $index): string
    {
        if (isset(self::$showitemDefaults[$index])) {
            return self::$showitemDefaults[$index];
        }
        throw new \UnexpectedValueException('showitemDefault with index "' . $index . '" not found', 1521492535);
    }
}
