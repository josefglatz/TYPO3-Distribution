<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Backend\CropVariants\Defaults;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use UnexpectedValueException;

class AspectRatio
{
    /**
     * Retrieve aspect ratios
     *
     * @param array $keys
     * @return array desired aspect ratios
     * @throws \UnexpectedValueException
     */
    public static function get(array $keys): array
    {
        $aspectRatios = Configuration::defaultConfiguration('aspectRatios');
        $ratios = [];
        foreach ($keys as $key) {
            if (isset($aspectRatios[$key])) {
                $new = $aspectRatios[$key];
                $ratios[$key] = [
                    'title' => $new['title'],
                    'value' => self::ratioCalculations((string)$new['value'])
                ];
            } else {
                throw new UnexpectedValueException(
                    'Given aspectRatio "' . $key . '" not found."',
                    1520426705);
            }
        }
        return $ratios;
    }

    /**
     * Calculate ratio of given string.
     * (Used for aspectRatio['value'] value)
     *
     * Supports following value syntax:
     * - "123 / 456"
     * - "0.45"
     * - "1"
     *
     * @param string $value
     * @return float
     * @throws \UnexpectedValueException
     */
    private static function ratioCalculations(string $value): float
    {
        $value = GeneralUtility::trimExplode('/', $value, true);
        if (\count($value) === 1) {
            return (float)$value;
        }
        if (\count($value) === 2) {
            return $value[0] / $value[1];
        }
        throw new UnexpectedValueException('AspectRatio value not valid! Please provide a division or a float number.', 1524838980);
    }
}
