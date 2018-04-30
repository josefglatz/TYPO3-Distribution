<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Signals;

/**
 * Slot for generating cropVariants configuration out of a YAML configuration
 */
class Tca
{
    /**
     * Handle tcaIsBeingBuilt signal and return TCA afterwards
     *
     * @param $tca
     * @return array
     */
    public function handleTcaIsBeingBuilt($tca)
    {
//        print_r($tca);die;
        return [$tca];
    }
}
