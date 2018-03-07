<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Utility\CropVariants;

class CoverAreaDefaults
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
                'x' => 0.75,
                'y' => 0.0,
                'width' => 1.0,
                'height' => 0.25
            ]
        ]
    ];

    /**
     * Retrieve cover area presets
     *
     * @param array $keys
     * @return array all retrieved cover areas
     */
    public static function get(array $keys): array
    {
        $coverAreas = [];
        foreach ($keys as $key) {
            if (isset(self::$coverAreaPresets['key']) && \is_array(self::$coverAreaPresets['key'])) {
                $coverAreas[] = self::$coverAreaPresets[$key];
            } else {
                throw new \UnexpectedValueException('Given coverArea preset "' . $key . '" not found or not from type array."', 1520430221);
            }
        }

        return $coverAreas;
    }
}
