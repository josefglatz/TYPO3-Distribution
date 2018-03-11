<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Utility\CropVariants;

class CropVariantDefaults
{
    /**
     *
     *
     * @var array
     */
    protected static $defaultCropVariants = [
        'default'
    ];

    /**
     * Retrieve as default declared cropVariants
     *
     * @return array default cropVariants (only key)
     */
    public static function getDefaultCropVariants(): array
    {
        return self::$defaultCropVariants;
    }
}
