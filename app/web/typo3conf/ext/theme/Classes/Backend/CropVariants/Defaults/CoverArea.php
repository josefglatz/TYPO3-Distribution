<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Backend\CropVariants\Defaults;

class CoverArea
{
    /**
     * Retrieve cover area presets
     *
     * @TODO: split single vs multiple (get, getMultiple)
     *
     * @param array $keys
     * @return array all retrieved cover areas
     * @throws \UnexpectedValueException
     */
    public static function get(array $keys): array
    {
        $coverAreaPresets = Configuration::defaultConfiguration('coverAreas');
        $coverAreas = [];
        foreach ($keys as $key => $item) {
            if (isset($coverAreaPresets[$item]) && \is_array($coverAreaPresets[$item])) {
                foreach ($coverAreaPresets[$item] as $coverAreaPresetArray) {
                    $coverAreas[] = $coverAreaPresetArray;
                }
            } else {
                throw new \UnexpectedValueException('Given coverArea preset "' . $key . '" not found or not from type array."', 1520430221);
            }
        }
        return $coverAreas;
    }
}
