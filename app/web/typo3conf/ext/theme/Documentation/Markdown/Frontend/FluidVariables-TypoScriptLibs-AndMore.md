Back to [Index](../Index.md) / Back to [Frontend Index](Index.md)

---

# Overview: Fluid variables, CSS classes, TypoScript Libs, Important to know stuff

## Fluid variables

| Variable | Title |
|-------|-------|
| `{RootUid}` | Dynamic UID of the actual root page |
| `{Level1Title}` | Title of level 1 of current page |
| `{MainNavigation}` | Main Navigation |
| `{PrimaryMainNavigation}` | Main Navigation (for main navigation) |
| `{SecondaryMainNavigation}` | Main Navigation (for meta navigation) |
| `{SubNavigation}` | Sub Navigation (entryLevel 1) |
| `{BreadcrumbNavigation}` | Breadcrumb with level dependent switch |
| `{MetaNavigation}` | Good old Meta Navigation (subpages of specific PID) |
| `{FooterNavigation}` | Footer Navigation (subpages of specific PID) |
| `{SocialNavigation}` | Social Links Navigation (subpages of specific PID) |
| `{LanguageNavigation}` | Language Navigation |
| `{BreadcrumbNavigationDetail}` | for EXT:news |

## CSS Classes and Attributes

| Body class | Description | Prefix |
|-------|-------|-------------------|
| `language-<syslanguageUid>` | Class based on actual sys_language_uid | `language-`
| `languagecontent-<sysLanguageContent>` | Class based on actual content language | `languagecontent-`
| `level-<levelOfActualPage>` | Class with actual treeLevel | `level-`
| `tmpl-<ActualBackendLayout>` | Class with actual backendLayout | `tmpl-`
| `layout-<pagesLayoutField>` | Class with value of pages.layout field  | `layout-`
| `root-<UidOfRootPage>` | Class with uid of rootpage (automatically!)  | `root-`
| `rootpage` | class is added if actual page is the root page (automatically) |
| _backendLayout CASE_ | Optional to uncomment: ready2use TypoScript CASE config to add custom backendLayout/FluidTemplate class mapping |

## Body attributes

| Body attribute | Description |
|-------|-------|
| data-page-uid=`actualPageUid` | UID of actual page |


## Replacement Markers

| Body attribute | Description | Technically via |
|-------|-------|--------------------------------|
| `###CURRENTYEAR###` | four-digit actual year | TypoScript `page.stdWrap.replacement`
| `###SPACE###` | Space charactar "32" | TypoScript `page.stdWrap.replacement`


## Typoscript Libs

| TypoScript patch | Description | Details |
|-------|-------|--------------------------------|
| `lib.fluidTemplate.default` | for primary `FLUIDTEMPLATE` configuration | is used as a standard in `PAGE` configuration
| `lib.dynamicContent` | to retrieve content elements in Fluid via VH | primary method to render content elements
| `lib.dynamicContentSlide` | same as above with sliding/inheritance active |
| `lib.dynamicContentFirst` | same as above with only first content element |
| `lib.countContent` | retrieve amount of content elements for a specific colPos | primary used for Fluid If/Else conditions
| `lib.googleAnalyticsBasic` | Simple Google Analytics snippet |
| `lib.googleTagManagerBasic` | Simple Google Tag Manager snippet |
| `lib.matomoBasic` | Simple Matomo (former Piwik) snippet |
| `lib.titleTag.default` | Simple configurable title tag setup |
