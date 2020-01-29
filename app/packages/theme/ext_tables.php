<?php
/**
 * !!!!!!!!
 * HAVE IN MIND that ext_tables.php **ISN'T** loaded in a frontend request
 * !!!!!!!!
 */
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extKey) {

        /*
         * Register icons
         */
        // register svg icons: identifier and filename
        $iconsSvg = [
            'theme-backend-clear-processedfiles' => 'theme-backend-clear-processedfiles.svg',

            'apps-pagetree-folder-contains-landingpages' => 'theme-pagetree-folder-contains-landingpages.svg',
            'apps-pagetree-folder-dark'                  => 'theme-pagetree-folder-dark.svg',
            'apps-pagetree-page-contains-attention'      => 'theme-pagetree-page-contains-attention.svg',
            'apps-pagetree-page-contains-impress'        => 'theme-pagetree-page-contains-impress.svg',
            'apps-pagetree-page-contains-newsplugins'    => 'theme-pagetree-page-contains-news.svg',

            'theme-content-accordion'        => 'GridElements/theme-content-gridelement-accordion.svg',
            'theme-content-badge'            => 'theme-content-badge.svg',
            'theme-content-call-to-action'   => 'theme-content-call-to-action.svg',
            'theme-content-carousel'         => 'GridElements/theme-content-gridelement-carousel.svg',
            'theme-content-download'         => 'theme-content-download.svg',
            'theme-content-factbox'          => 'theme-content-factbox.svg',
            'theme-content-facts-figures'    => 'theme-content-facts-figures.svg',
            'theme-content-form'             => 'theme-content-form.svg',
            'theme-content-gallery'          => 'theme-content-gallery.svg',
            'theme-content-image-big'        => 'theme-content-image-big.svg',
            'theme-content-inheritance-stop' => 'theme-content-inheritance-stop.svg',
            'theme-content-logos'            => 'theme-content-logos.svg',
            'theme-content-map'              => 'theme-content-map.svg',
            'theme-content-person'           => 'theme-content-person.svg',
            'theme-content-testimonial'      => 'theme-content-testimonial.svg',
            'theme-content-text-lead'        => 'theme-content-text-lead.svg',
            'theme-content-text-right'       => 'theme-content-text-right.svg',
            'theme-content-timeline'         => 'theme-content-timeline.svg',
            'theme-content-youtube'          => 'theme-content-youtube.svg',

            'theme-content-gridelement'                             => 'GridElements/theme-content-gridelement.svg',
            'theme-content-gridelement-2-col'                       => 'GridElements/theme-content-gridelement-2-col.svg',
            'theme-content-gridelement-3-col'                       => 'GridElements/theme-content-gridelement-3-col.svg',
            'theme-content-gridelement-4-col'                       => 'GridElements/theme-content-gridelement-4-col.svg',
            'theme-content-gridelement-accordion'                   => 'GridElements/theme-content-gridelement-accordion.svg',
            'theme-content-gridelement-carousel'                    => 'GridElements/theme-content-gridelement-carousel.svg',
            'theme-content-gridelement-container'                   => 'GridElements/theme-content-gridelement-container.svg',
            'theme-content-gridelement-single-column-header-footer' => 'GridElements/theme-content-gridelement-single-column-header-footer.svg',
            'theme-content-gridelement-single-column-horizontal'    => 'GridElements/theme-content-gridelement-single-column-horizontal.svg',
            'theme-content-gridelement-single-column-vertical'      => 'GridElements/theme-content-gridelement-single-column-vertical.svg',
            'theme-content-gridelement-tab'                         => 'GridElements/theme-content-gridelement-tab.svg',

            'theme-belayout-content'                => 'BackendLayouts/content.svg',
            'theme-belayout-content-empty'          => 'BackendLayouts/content-empty.svg',
            'theme-belayout-content-homepage'       => 'BackendLayouts/content-homepage.svg',
            'theme-belayout-content-product'        => 'BackendLayouts/content-product.svg',
            'theme-belayout-content-rubric'         => 'BackendLayouts/content-rubric.svg',
            'theme-belayout-content-menu'           => 'BackendLayouts/content-menu.svg',
            'theme-belayout-content-menu-sidebar'   => 'BackendLayouts/content-menu-sidebar.svg',
            'theme-belayout-content-sidebar'        => 'BackendLayouts/content-sidebar.svg',
            'theme-belayout-content-sidebar-menu'   => 'BackendLayouts/content-sidebar-menu.svg',
            'theme-belayout-content-special'        => 'BackendLayouts/content-special.svg',
            'theme-belayout-default'                => 'BackendLayouts/default.svg',
            'theme-belayout-menu-content'           => 'BackendLayouts/menu-content.svg',
            'theme-belayout-menu-content-sidebar'   => 'BackendLayouts/menu-content-sidebar.svg',
            'theme-belayout-menu-sidebar-content'   => 'BackendLayouts/menu-sidebar-content.svg',
            'theme-belayout-sidebar-content'        => 'BackendLayouts/sidebar-content.svg',
            'theme-belayout-sidebar-content-menu'   => 'BackendLayouts/sidebar-content-menu.svg',
            'theme-belayout-sidebar-menu-content'   => 'BackendLayouts/sidebar-menu-content.svg',
        ];
        $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
        foreach ($iconsSvg as $identifier => $path) {
            $iconRegistry->registerIcon(
                $identifier,
                \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                ['source' => 'EXT:' . $extKey . '/Resources/Public/Icons/Backend/' . $path]
            );
        }

        // to register bitmap icons (e.g. png) you must register them using the BitmapIconProvider

        // Add CSH descriptions
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'sys_file_reference',
            'EXT:' . $extKey . '/Resources/Private/Language/locallang_csh_sys_file_reference.xlf'
        );

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_theme_facts_figures'
        );
    },
    'theme'
);
