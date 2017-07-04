<?php
/**
 * This file is part of the TYPO3 CMS distribution "jousch/TYPO3-Distribution".
 *
 *
 */
namespace Sup7even\Theme\Hooks\Backend\Toolbar;

use TYPO3\CMS\Backend\Toolbar\ToolbarItemInterface;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Beuser\Domain\Model\BackendUser;
use TYPO3\CMS\Beuser\Domain\Repository\BackendUserRepository;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Core\Database\ConnectionPool;

/**
 * Main functionality to render a list of backend users to which it is possible to switch as an admin
 */
class BackendUserPreviewToolbarItem implements ToolbarItemInterface
{
    /**
     * @var array
     */
    protected $availableUsers = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->loadAvailableBeUsers();
    }

    /**
     * Checks whether the user has access to this toolbar item and is not disabled via TSConfig
     *
     * @return bool TRUE if user has access and toolbarItem is enabled, FALSE if not
     */
    public function checkAccess(): bool
    {
        $conf = $this->getBackendUserAuthentication()->getTSConfig('backendToolbarItem.beUserFastwitch.disabled');
        return (int)$conf['value'] !== 1 && $this->getBackendUserAuthentication()->isAdmin() && !$this->getBackendUserAuthentication()->user['ses_backuserid'];
    }

    /**
     * Loads all eligible backend users
     */
    public function loadAvailableBeUsers()
    {
        if ($this->checkAccess()) {
            $this->availableUsers = $this->getBackendUserRows();
        }
    }

    /**
     * Render toolbar icon via Fluid
     *
     * @return string HTML
     */
    public function getItem(): string
    {
        $view = $this->getFluidTemplateObject('ToolbarItem.html');
        return $view->render();
    }

    /**
     * Render drop down via Fluid
     *
     * @return string HTML
     */
    public function getDropDown(): string
    {
        $view = $this->getFluidTemplateObject('DropDown.html');
        $view->assignMultiple([
            'users' => $this->availableUsers
        ]);
        return $view->render();
    }

    /**
     * No additional attributes
     *
     * @return array List item HTML attibutes
     */
    public function getAdditionalAttributes(): array
    {
        return [];
    }

    /**
     * This item has a drop down
     *
     * @return bool
     */
    public function hasDropDown(): bool
    {
        return true;
    }

    /**
     * Position relative to others
     *
     * @return int
     */
    public function getIndex(): int
    {
        return 10;
    }

    /**
     * Returns the current BE user.
     *
     * @return BackendUserAuthentication
     */
    protected function getBackendUserAuthentication(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }

    /**
     * Returns a new standalone view, shorthand function
     * @TODO Move Fluid files to another folder within private folder
     *
     * @param string $filename Which templateFile should be used.
     * @return StandaloneView
     */
    protected function getFluidTemplateObject(string $filename): StandaloneView
    {
        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->setLayoutRootPaths(['EXT:theme/Resources/Private/Backend/ToolbarItems/Layouts']);
        $view->setPartialRootPaths([
            'EXT:backend/Resources/Private/Partials/Backend/ToolbarItems',
            'EXT:theme/Resources/Private/Backend/ToolbarItems/Partials'
        ]);
        $view->setTemplateRootPaths(['EXT:theme/Resources/Private/Backend/ToolbarItems/Templates']);

        $view->setTemplate($filename);

        $view->getRequest()->setControllerExtensionName('Theme');
        return $view;
    }

    /**
     * Retrieve available backend users
     * @TODO: Streamline method (do not combine raw result with object)
     *
     * @return array
     */
    protected function getBackendUserRows(): array
    {
        $queryBuiler = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('be_users');
        $queryBuiler->getRestrictions()
            ->removeAll()
            ->add(GeneralUtility::makeInstance(DeletedRestriction::class));
        $rows = $queryBuiler->select('*')
            ->from('be_users')
            ->where(
                $queryBuiler->expr()
                    ->andX(
                        $queryBuiler->expr()->eq(
                            'admin',
                            $queryBuiler->createNamedParameter(0, \PDO::PARAM_INT)
                        ),
                        $queryBuiler->expr()->neq(
                            'uid',
                            $queryBuiler->createNamedParameter($this->getBackendUserAuthentication()->user['uid'], \PDO::PARAM_INT)
                        )
                    )

            )
            ->execute()
            ->fetchAll();


        /** @var $extbaseObjectManager \TYPO3\CMS\Extbase\Object\ObjectManager */
        $extbaseObjectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var $backendUserRepository BackendUserRepository */
        $backendUserRepository = $extbaseObjectManager->get(BackendUserRepository::class);

        foreach ($rows as $row) {
            /** @var  $userObject BackendUser */
            $userObject = $backendUserRepository->findByUid($row['uid']);
            $objectRows[] = [
                $userObject,
                $row
            ];
        }

        return $objectRows;
    }
}
