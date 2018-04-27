<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Backend\CropVariants\Defaults;

class CropArea
{
    /**
     * Retrieve crop area
     *
     * @param string $name
     * @return array cropArea (default cropArea if no parameter was hand over)
     * @throws \UnexpectedValueException
     */
    public static function get(string $name = 'default'): array
    {
        $cropAreas = Configuration::defaultConfiguration('cropAreas');
        if (isset($cropAreas[$name]) && \is_array($cropAreas[$name])) {
            return $cropAreas[$name];
        }
        throw new \UnexpectedValueException('Given crop area "' . $name . '" not found."', 1520429257);
    }
}
