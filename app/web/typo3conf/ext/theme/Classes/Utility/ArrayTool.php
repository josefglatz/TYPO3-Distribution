<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Utility;

class ArrayTool
{
    /**
     * Check for existing keys in an array
     *
     * @param array $requiredKeys
     * @param $arrayToCheck
     * @return bool
     */
    public static function arrayKeysExists(array $requiredKeys, $arrayToCheck): bool
    {
        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $arrayToCheck)) {
                return false;
            }
        }
        return true;
    }
}
