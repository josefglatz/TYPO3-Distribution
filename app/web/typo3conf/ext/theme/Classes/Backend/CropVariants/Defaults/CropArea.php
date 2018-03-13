<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Backend\CropVariants\Defaults;

class CropArea
{
    /**
     * @var array cropArea configuration
     */
    protected static $cropAreas = [
        'default' => [
            'x' => '0.0',
            'y' => '0.0',
            'width' => '1.0',
            'height' => '1.0'
        ],
    ];

    /**
     * Retrieve crop area
     *
     * @param string $name
     * @return array cropArea (default cropArea if no parameter was hand over)
     */
    public static function get(string $name = 'default'): array
    {
        if (isset(self::$cropAreas[$name]) && \is_array(self::$cropAreas[$name])) {
            return self::$cropAreas[$name];
        }
        throw new \UnexpectedValueException('Given crop area "' . $name . '" not found."', 1520429257);
    }
}
