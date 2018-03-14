<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Backend\CropVariants\Defaults;

class CoverArea
{
    /**
     * @var array cropArea configuration
     */
    protected static $coverAreaPresets = [
        // 1_1_circle can be used for square image (1:1) with CSS `border-radius: 50%` (Tries to cover edges)
        '1_1_circle' => [
            [
                'x' => 0.0,
                'y' => 0.0,
                'width' => 0.25,
                'height' => 0.25
            ],
            [
                'x' => 0.75,
                'y' => 0.0,
                'width' => 0.25,
                'height' => 0.25
            ],
            [
                'x' => 0.0,
                'y' => 0.75,
                'width' => 0.25,
                'height' => 0.25
            ],
            [
                'x' => 0.75,
                'y' => 0.75,
                'width' => 0.25,
                'height' => 0.25
            ]
        ],
        // Cover lower third of image
        'lower_third' => [
            [
                'x' => 0.0,
                'y' => 0.67,
                'width' => 1.0,
                'height' => 0.33
            ]
        ]
    ];

    /**
     * Retrieve cover area presets
     *
     * @TODO: split single vs multiple (get, getMultiple)
     *
     * @param array $keys
     * @return array all retrieved cover areas
     */
    public static function get(array $keys): array
    {
        $coverAreas = [];
        foreach ($keys as $key => $item) {
            if (isset(self::$coverAreaPresets[$item]) && \is_array(self::$coverAreaPresets[$item])) {
                foreach (self::$coverAreaPresets[$item] as $coverAreaPresetArray) {
                    $coverAreas[] = $coverAreaPresetArray;
                }
            } else {
                throw new \UnexpectedValueException('Given coverArea preset "' . $key . '" not found or not from type array."', 1520430221);
            }
        }
        return $coverAreas;
    }
}
