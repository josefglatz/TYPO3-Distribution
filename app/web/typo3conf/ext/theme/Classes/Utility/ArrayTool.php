<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Utility;

class ArrayTool
{
    /**
     * Check for existing keys in an array
     * Example: Checks if all required array keys exists in an array
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

    /**
     * Returns a given CamelCasedString as an array.
     * (The first character of the provided string will be transformed to lowercase)
     * Example: Converts BlogExample to ['blog','Example'], and minimalValue to ['minimal','Value']
     *
     * @param string $camelCasedString
     * @param bool $lcfirstChar
     * @return array
     */
    public static function explodeCamelCase(string $camelCasedString, bool $lcfirstChar = true): array
    {
        $camelCasedString = trim($camelCasedString);
        if ($lcfirstChar) {
            $camelCasedString = lcfirst($camelCasedString);
        }
        $array = preg_split('/(?=[A-Z])/',$camelCasedString);

        return $array;
    }
}
