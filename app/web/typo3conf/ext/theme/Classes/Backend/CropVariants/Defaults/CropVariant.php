<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Backend\CropVariants\Defaults;

class CropVariant
{
    /**
     * Retrieve as default declared cropVariants
     *
     * @return array default cropVariants (only key)
     */
    public static function getDefaultCropVariantsNames(): array
    {
        $defaultCropVariantsConfiguration = Configuration::defaultConfiguration('defaultCropVariantsConfiguration');
        return array_keys($defaultCropVariantsConfiguration);
    }
}
