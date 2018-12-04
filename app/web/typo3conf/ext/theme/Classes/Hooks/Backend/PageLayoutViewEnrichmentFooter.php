<?php declare(strict_types=1);

namespace JosefGlatz\Theme\Hooks\Backend;

use JosefGlatz\Theme\Configuration\ExtensionConfiguration;
use JosefGlatz\Theme\Utility\ArrayTool;
use TYPO3\CMS\Backend\View\PageLayoutViewDrawFooterHookInterface;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Localization\LanguageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class PageLayoutViewEnrichmentFooter implements PageLayoutViewDrawFooterHookInterface
{
    public const BADGETYPE_INFO = 'info';
    public const BADGETYPE_IS = 'is';
    public const BADGETYPE_ISNOT = 'isNot';
    public const COLUMN_PREFIX = 'tx_theme_';
    protected const LLLPATH = 'LLL:EXT:theme/Resources/Private/Language/locallang_BackendGeneral.xlf:';
    protected const LLLPATHPREFIX = 'field.';
    protected const LLLPATHSUFFIX = '.label';
    protected const LLLPATHSUFFIX_BADGE = '.badge';

    /**
     * Configuration for footer enrichments
     *
     * @var array
     */
    protected $enrichtmentConfiguration = [];

    /**
     * Table of record
     *
     * @var string
     */
    protected $table = '';

    /**
     * Record type (CType)
     *
     * @var string
     */
    protected $type = '';

    /**
     * Preprocess the footer rendering of a content element.
     *
     * @param \TYPO3\CMS\Backend\View\PageLayoutView $parentObject Calling parent object
     * @param string $info Processed values
     * @param array $row Record row of tt_content
     * @throws \Exception
     */
    public function preProcess(\TYPO3\CMS\Backend\View\PageLayoutView &$parentObject, &$info, array &$row)
    {
        $this->enrichtmentConfiguration = $GLOBALS['TCA'][$parentObject->table]['types'][$row['CType']]['pageLayoutViewEnrichment']['footer'];
        $this->table = $parentObject->table;
        $this->type = $row['CType'];
        $newElements = [
            'badges' => [],
            'CType' => ''
        ];

        // CType value
        if ($this->isEnabled() && ($this->isDevelopmentEnvironment() || $this->getBackendUser()->isAdmin())) {
            $newElements['CType'] = $row['CType'];
        }

        if ($this->enrichmentConfigExists()) {
            // Register all valid badges for the view
            if ($this->badgesConfigExists()) {
                foreach ($this->enrichtmentConfiguration['badges'] as $badge) {
                    // Check if type can be handled by implementation
                    $result = $this->getBadgeType($badge);
                    if ($result[0] && $this->columnExists($result[1])) {
                        $newElements['badges'][$badge] = [
                            'badgeType' => ucfirst($result[0]),
                            'column' => $this->getColumnName($result[1]),
                            'value' => $row[$this->getColumnName($result[1])],
                            'lllString' => $this->defaultLocalizationAttempt($this->getColumnName($result[1]))
                        ];
                    }
                }
            }
        }

        // Set up view
        $view = $this->getFluidTemplateObject('FooterEnrichment.html');
        $view->assignMultiple([
            'data' => $row,
            'currentSysLanguage' => $parentObject->tt_contentConfig['sys_language_uid'],
        ]);
        if ($newElements['CType']) {
            $view->assign('showCType', $newElements['CType']);
        }
        if (!empty($newElements['badges'])) {
            $view->assign('badges', $newElements['badges']);
        }
        // "return" final HTML markup of this hook
        $info[] = $view->render();
    }

    /**
     * Check if basic footer enrichment configuration exists
     *
     * @return bool
     */
    protected function enrichmentConfigExists(): bool
    {
        return \is_array($this->enrichtmentConfiguration) && !empty($this->enrichtmentConfiguration);
    }

    /**
     * Check if badges configuration basically exists
     *
     * @return bool
     */
    protected function badgesConfigExists(): bool
    {
        $config = $this->enrichtmentConfiguration;
        return ArrayTool::arrayKeysExists(['badges'], $config) && \is_array($config['badges']) && !empty($config['badges']);
    }

    /**
     * Get final column name
     * Tries first to check if the column exists without prefix and secondly with prefix.
     *
     * @param $name
     * @return string
     */
    protected function getColumnName($name): string
    {
        $finalColumnName = '';
        if (isset($GLOBALS['TCA'][$this->table]['columns'][$name])) {
            $finalColumnName = $name;
        }
        $prefixedName = self::COLUMN_PREFIX . $name;
        if (isset($GLOBALS['TCA'][$this->table]['columns'][$prefixedName])) {
            $finalColumnName = $prefixedName;
        }

        return $finalColumnName;
    }

    /**
     * Check if column exists in TCA
     *
     * @param string $name
     * @return bool
     */
    private function columnExists(string $name): bool
    {
        return (bool)$this->getColumnName($name);
    }

    /**
     * Translation attempt based on label convention with fallback to TCA default
     *
     *  1. Try CType specific badge overwrite label   (field.tablename.tx_theme_column_name.label.badge.type)
     *  2. Try generic badge overwrite label          (field.tablename.tx_theme_column_name.label.badge)
     *  3. Fallback to default column label           (field.tablename.tx_theme_column_name.label)
     *  4. Fallback to default column label           ($GLOBALS['TCA']['table']['columns']['column']['label'])
     *
     * @param string $column
     * @return string 'LLL:...' string or empty string if localization wasn't successful
     * @throws \InvalidArgumentException
     */
    protected function defaultLocalizationAttempt(string $column): string
    {
        $lll = self::LLLPATH . self::LLLPATHPREFIX . $this->table . '.' . $column . self::LLLPATHSUFFIX;
        $lllBadge = $lll . self::LLLPATHSUFFIX_BADGE;
        $lllBadgeType = $lllBadge . '.' . $this->type;
        $lllTca = '';
        if (isset($GLOBALS['TCA'][$this->table]['columns'][$column]['label'])) {
            $lllTca = $GLOBALS['TCA'][$this->table]['columns'][$column]['label'];
        }
        if (!empty($this->getLanguageService()->sL($lllBadgeType))) {
            return $lllBadgeType;
        }
        if (!empty($this->getLanguageService()->sL($lllBadge))) {
            return $lllBadge;
        }
        if (!empty($this->getLanguageService()->sL($lll))) {
            return $lll;
        }

        return $lllTca;
    }

    /**
     * Retrieve badge type
     * Checks if provided camelCasedString begins with specific strings
     *
     * @param string $key
     * @return array
     */
    protected function getBadgeType(string $key): array
    {
        $type = '';
        $columnName = '';
        $keyParts = ArrayTool::explodeCamelCase($key);
        // is / is not
        if ($keyParts[0] === 'is') {
            if ($keyParts[1] === 'Not') {
                $type = self::BADGETYPE_ISNOT;
                $columnName = strtolower(implode('_', \array_slice($keyParts, 2)));
            } else {
                $type = self::BADGETYPE_IS;
                $columnName = strtolower(implode('_', \array_slice($keyParts, 1)));
            }
        }
        if ($keyParts[0] === 'info') {
            $type = self::BADGETYPE_INFO;
            $columnName = strtolower(implode('_', \array_slice($keyParts, 1)));
        }

        return [$type, $columnName];
    }

    /**
     * Check if current applicationContext is a development environment
     *
     * @return bool
     */
    protected function isDevelopmentEnvironment(): bool
    {
        return GeneralUtility::getApplicationContext()->isDevelopment()
            || (GeneralUtility::getApplicationContext()->isProduction()
                && GeneralUtility::getApplicationContext()->__toString() === 'Production/Dev');
    }

    /**
     * Check if feature is enabled
     *
     * @return bool
     * @throws \Exception
     */
    protected function isEnabled(): bool
    {
        return GeneralUtility::makeInstance(ExtensionConfiguration::class)->isPageLayoutViewEnrichmentFooter();
    }

    /**
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }

    /**
     * Returns the current BE user.
     *
     * @return BackendUserAuthentication
     */
    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }

    /**
     * Returns a new standalone view, shorthand function
     *
     * @param string $templateFilename Which templateFile should be used.
     * @return StandaloneView
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\InvalidExtensionNameException
     */
    protected function getFluidTemplateObject(string $templateFilename): StandaloneView
    {
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setLayoutRootPaths(['EXT:theme/Resources/Private/Layouts']);
        $view->setPartialRootPaths(['EXT:theme/Resources/Private/Partials']);
        $view->setTemplateRootPaths(['EXT:theme/Resources/Private/Templates/Backend/PageLayout']);
        $view->setTemplate($templateFilename);
        $view->getRequest()->setControllerExtensionName('Theme');
        return $view;
    }
}
