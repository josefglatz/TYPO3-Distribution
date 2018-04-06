<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Backend\CropVariants\Defaults;

class FocusArea
{
    /**
     * @var array focusArea configuration
     */
    protected static $focusArea = [
        '0.75' => [
            'x' => '0.125',
            'y' => '0.125',
            'width' => '0.75',
            'height' => '0.75'
        ],
        '0.5' => [
            'x' => '0.25',
            'y' => '0.25',
            'width' => '0.5',
            'height' => '0.5'
        ],
        '0.25' => [
            'x' => '0.375',
            'y' => '0.375',
            'width' => '0.25',
            'height' => '0.25'
        ],
    ];

    /**
     * Retrieve focus area
     *
     * @param string $name
     * @return array focusArea (no default is returned as there is no focusArea necessary)
     */
    public static function get(string $name): array
    {
        if (isset(self::$focusArea[$name]) && \is_array(self::$focusArea[$name])) {
            return self::$focusArea[$name];
        }
        throw new \UnexpectedValueException('Given focus area "' . $name . '" not found."', 1522992127);
    }
}
