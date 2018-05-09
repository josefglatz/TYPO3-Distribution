<?php declare(strict_types = 1);

namespace JosefGlatz\Theme\Signals;

use JosefGlatz\Theme\Backend\CropVariants\Defaults\Configuration;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/**
 * Slot for generating cropVariants configuration out of a YAML configuration
 */
class Tca
{
    /**
     * Table Configuration Array
     * (which is passed vy signal slot)
     *
     * @var array
     */
    protected $tca = [];

    /**
     * Yaml configuration array
     *
     * @var array
     */
    protected $yamlConfiguration = [];

    /**
     * Processed CropVariants Table Configuration Array part
     *
     * @var array
     */
    protected $processedCropVariants = [];

    /**
     * Handle tcaIsBeingBuilt signal and return TCA afterwards
     *
     * @param $tca
     * @return array
     */
    public function handleTcaIsBeingBuilt($tca): array
    {
        DebuggerUtility::var_dump($tca);
        $this->tca = $tca;
        $this->yamlConfiguration = Configuration::defaultConfiguration('cropVariantsConfiguration', false);

        // Check if any children exists
            // For each children:
                // check if $key exists as already configured table
                    // if not: throw exception
                // if table configuration exists:
                    // $this->processTable


//        print_r($tca);die;
        return [$tca];
    }

    protected function processTable()
    {

    }

    protected function checkIfTableConfigurationExists()
    {

    }
}
