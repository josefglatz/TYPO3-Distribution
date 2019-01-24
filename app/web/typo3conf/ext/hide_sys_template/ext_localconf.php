<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey) {

        // Edit restriction for specific records / Enrich DataHandler while updating specific records
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['theme'] =
            \JosefGlatz\HideSysTemplate\Hooks\Backend\ProcessDatamapDataHandler::class;
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS'][TYPO3\CMS\Tstemplate\Controller\TypoScriptTemplateModuleController::class]['newStandardTemplateHandler'] =
            \JosefGlatz\HideSysTemplate\Hooks\Backend\NewStandardTemplateHandler::class . '->restrict';

        // Only backend relevant stuff
        if (TYPO3_MODE === 'BE') {
            /**
             * Instantiate SignalSlot Dispatcher
             *
             * @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher
             */
            $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);

            // Edit restriction for specific new records
            $signalSlotDispatcher->connect(
                \TYPO3\CMS\Backend\Controller\EditDocumentController::class,
                'preInitAfter',
                \JosefGlatz\HideSysTemplate\Signals\Backend\EditDocumentControllerInitSlot::class,
                'adjustEditDocumentController'
            );
        }
    },
    'hide_sys_template'
);
