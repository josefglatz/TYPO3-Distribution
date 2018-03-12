<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Utility\CropVariants;

class AspectRatioDefaults
{
    /**
     * @var array Default aspect ratios configuration
     */
    protected static $aspectRatios = [
        // Open Graph, Facebook, Twitter Image (official @ early 2018)
        '1.91:1' => [
            'title' => '1.91:1 (Open Graph, Facebook, Twitter)',
            'value' => 1.91 / 1
        ],
        // Common used for wide sujet images
        '3:1' => [
            'title' => '3:1',
            'value' => 3 / 1
        ],
        // Common video format
        '16:9' => [
            'title' => 'LLL:EXT:lang/Resources/Private/Language/locallang_wizards.xlf:imwizard.ratio.16_9',
            'value' => 16 / 9
        ],
        // Common DSLR/SLR format
        '3:2' => [
            'title' => 'LLL:EXT:lang/Resources/Private/Language/locallang_wizards.xlf:imwizard.ratio.3_2',
            'value' => 3 / 2
        ],
        '2:3' => [
            'title' => '2:3',
            'value' => 2 / 3
        ],
        // Common used for wide sujet images
        '2:1' => [
            'title' => '2:1',
            'value' => 2 / 1
        ],
        // Common Point'n'Shoot camera format
        '4:3' => [
            'title' => 'LLL:EXT:lang/Resources/Private/Language/locallang_wizards.xlf:imwizard.ratio.4_3',
            'value' => 4 / 3
        ],
        '3:4' => [
            'title' => '3:4',
            'value' => 3 / 4
        ],
        // Square image format
        '1:1' => [
            'title' => 'LLL:EXT:lang/Resources/Private/Language/locallang_wizards.xlf:imwizard.ratio.1_1',
            'value' => 1.0
        ],
        // Common large/medium camera format
        '5:4' => [
            'title' => '5:4',
            'value' => 5 / 4
        ],
        '4:5' => [
            'title' => '4:5',
            'value' => 4 / 5
        ],
        // Free ratio / no ratio limitation
        'NaN' => [
            'title' => 'LLL:EXT:lang/Resources/Private/Language/locallang_wizards.xlf:imwizard.ratio.free',
            'value' => 0.0
        ]
    ];

    protected const defaultAspectRatios = [
        '3:2',
        '2:3',
        '4:3',
        '3:4',
        '1:1',
        'NaN'
    ];

    /**
     * Retrieve aspect ratios
     *
     * @param array $keys
     * @return array desired aspect ratios
     */
    public static function get(array $keys): array
    {
        $ratios = [];
        foreach ($keys as $key) {
            if (isset(self::$aspectRatios[$key])) {
                $ratios[$key] = self::$aspectRatios[$key];
            } else {
                throw new \UnexpectedValueException('Given aspectRatio "' . $key . '" not found."', 1520426705);
            }
        }

        return $ratios;
    }

    /**
     * Retrieve default aspect ratios
     *
     * @return array all default aspect ratios
     */
    public static function getDefaults(): array
    {
        // Check if every default aspect ratio exists
        if (\is_array(self::defaultAspectRatios)) {
            foreach (self::defaultAspectRatios as $ratio) {
                if (!isset(self::$aspectRatios[$ratio])) {
                    throw new \UnexpectedValueException('Wanted default aspectRatio "' . $ratio . '" is not configured.', 1520426750);
                }
            }
        } else {
            throw new \UnexpectedValueException('The given default aspectRatios configuration isn\'t from type array.', 1520426754);
        }

        return self::get(self::defaultAspectRatios);
    }
}
