<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Backend\Enrichment\Badge;


use JosefGlatz\Theme\Hooks\Backend\PageLayoutViewEnrichmentFooter;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class Configuration for Badges configuration
 *
 * @TODO: TYPO3-Distribution: refactor static methods to reduce amount of array writing (another static method around
 * the methods of this class)
 */
class Configuration
{
    /**
     * Static method to build configuration string
     * for badges
     *
     * == Examples ==
     *
     * Input: tx_theme_big_media
     * Output: isBigMedia
     *
     * Input: column_name
     * Output: ColumnName
     *
     * @param $column
     * @return string column name
     */
    public static function isTrue($column): string
    {
        return PageLayoutViewEnrichmentFooter::BADGETYPE_IS . GeneralUtility::underscoredToUpperCamelCase(trim($column));

    }

    /**
     * Static method to build configuration string
     * for badges
     *
     * == Examples ==
     *
     * Input: tx_theme_big_media
     * Output: isNotBigMedia
     *
     * Input: column_name
     * Output: isNotColumnName
     *
     * @param $column
     * @return string column name
     */
    public static function isFalse($column): string
    {
        return PageLayoutViewEnrichmentFooter::BADGETYPE_ISNOT . GeneralUtility::underscoredToUpperCamelCase(trim($column));

    }

    /**
     * Static method to build configuration string
     * for badges
     *
     * == Examples ==
     *
     * Input: tx_theme_big_media
     * Output: infoBigMedia
     *
     * Input: column_name
     * Output: infoColumnName
     *
     * @param $column
     * @return string column name
     */
    public static function info($column): string
    {
        return PageLayoutViewEnrichmentFooter::BADGETYPE_INFO . GeneralUtility::underscoredToUpperCamelCase(trim($column));

    }

    /**
     * Static method to build configuration string
     * for badges
     *
     * == Examples ==
     *
     * Input: tx_theme_big_media
     * Output: showValueBigMedia
     *
     * Input: column_name
     * Output: showValueColumnName
     *
     * @param $column
     * @return string column name
     */
    public static function showValue($column): string
    {
        return PageLayoutViewEnrichmentFooter::BADGETYPE_SHOW_VALUE . GeneralUtility::underscoredToUpperCamelCase(trim($column));

    }


}
