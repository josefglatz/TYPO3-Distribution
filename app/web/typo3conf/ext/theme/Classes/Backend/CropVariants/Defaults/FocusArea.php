<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Backend\CropVariants\Defaults;

class FocusArea
{
    /**
     * Retrieve focus area
     *
     * @param string $name
     * @return array focusArea (no default is returned as there is no focusArea necessary)
     * @throws \UnexpectedValueException
     */
    public static function get(string $name): array
    {
        $focusAreas = Configuration::defaultConfiguration('focusAreas');
        if (isset($focusAreas[$name]) && \is_array($focusAreas[$name])) {
            return $focusAreas[$name];
        }
        throw new \UnexpectedValueException('Given focus area "' . $name . '" not found."', 1522992127);
    }
}
