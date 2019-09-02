Back to [Index](../Index.md) / Back to [Frontend Index](Index.md)

# Overview: Fluid variables, CSS classes, TypoScript Libs, Important to know stuff

## Fluid variables

| Variable                       | Title                                               |
|:-------------------------------|:----------------------------------------------------|
| `{RootUid}`                    | Dynamic UID of the actual root page                 |
| `{Level1Title}`                | Title of level 1 of current page                    |
| `{MainNavigation}`             | Main Navigation                                     |
| `{PrimaryMainNavigation}`      | Main Navigation (for main navigation)               |
| `{SecondaryMainNavigation}`    | Main Navigation (for meta navigation)               |
| `{SubNavigation}`              | Sub Navigation (entryLevel 1)                       |
| `{BreadcrumbNavigation}`       | Breadcrumb with level dependent switch              |
| `{MetaNavigation}`             | Good old Meta Navigation (subpages of specific PID) |
| `{FooterNavigation}`           | Footer Navigation (subpages of specific PID)        |
| `{SocialNavigation}`           | Social Links Navigation (subpages of specific PID)  |
| `{LanguageNavigation}`         | Language Navigation                                 |
| `{BreadcrumbNavigationDetail}` | for EXT:news                                        |

## CSS Classes and Attributes

| Body class                             | Description                                                                                                     | Prefix             |
|:---------------------------------------|:----------------------------------------------------------------------------------------------------------------|:-------------------|
| `language-<syslanguageUid>`            | Class based on actual sys_language_uid                                                                          | `language-`        |
| `languagecontent-<sysLanguageContent>` | Class based on actual content language                                                                          | `languagecontent-` |
| `level-<levelOfActualPage>`            | Class with actual treeLevel                                                                                     | `level-`           |
| `tmpl-<ActualBackendLayout>`           | Class with actual backendLayout                                                                                 | `tmpl-`            |
| `layout-<pagesLayoutField>`            | Class with value of pages.layout field                                                                          | `layout-`          |
| `root-<UidOfRootPage>`                 | Class with uid of rootpage (automatically!)                                                                     | `root-`            |
| `rootpage`                             | class is added if actual page is the root page (automatically)                                                  |                    |
| _backendLayout CASE_                   | Optional to uncomment: ready2use TypoScript CASE config to add custom backendLayout/FluidTemplate class mapping |                    |

## Body attributes

| Body attribute                | Description        |
|:------------------------------|:-------------------|
| data-page-uid=`actualPageUid` | UID of actual page |


## Replacement Markers

| Body attribute      | Description            | Technically via                       |
|:--------------------|:-----------------------|:--------------------------------------|
| `###CURRENTYEAR###` | four-digit actual year | TypoScript `page.stdWrap.replacement` |
| `###SPACE###`       | Space charactar "32"   | TypoScript `page.stdWrap.replacement` |


## Typoscript Libs

| TypoScript patch            | Description                                                      | Details                                       |
|:----------------------------|:-----------------------------------------------------------------|:----------------------------------------------|
| `lib.fluidTemplate.default` | for primary `FLUIDTEMPLATE` configuration                        | is used as a standard in `PAGE` configuration |
| `lib.dynamicContent`        | to retrieve content elements in Fluid via VH                     | primary method to render content elements     |
| `lib.dynamicContentSlide`   | same as above with sliding/inheritance active                    |                                               |
| `lib.dynamicContentFirst`   | same as above with only first content element                    |                                               |
| `lib.countContent`          | retrieve amount of content elements for a one or multiple colPos | primary used for Fluid If/Else conditions     |
| `lib.googleAnalyticsBasic`  | Simple Google Analytics snippet                                  |                                               |
| `lib.googleTagManagerBasic` | Simple Google Tag Manager snippet                                |                                               |
| `lib.matomoBasic`           | Simple Matomo (former Piwik) snippet                             |                                               |
| `lib.titleTag.default`      | Simple configurable title tag setup                              |                                               |


## Frontend ViewHelpers (many of them could be used in TYPO3 backend context too)

| Name                           | Purpose of ViewHelper                                                                                                                                                                                                                                |
|:-------------------------------|:-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `theme:or`                     | If content is empty use alternative text (can also be LLL:labelname shortcut or LLL:EXT: file paths). Initially copied from EXT:vhs to get rid of dependencies for backend previews.                                                                 |
| `theme:fal`                    | FAL file relations. E.g. for Fluid Standalone Views (where no dataProcessing is available)                                                                                                                                                           |
| `theme:fileCollection`         | FAL file relations from file collections. E.g. for Fluid Standalone Views (where no dataProcessing is available)                                                                                                                                     |
| `theme:debug.typoScript`       | Debug full TypoScript configuration array. (The ViewHelper only works in development application context)                                                                                                                                            |
| `theme:format.cleanupString`   | Cleanup a string depending on the arguments. Supported is the removal of whitespace, tabs, combined line breaks, unix line breaks, windows line breaks                                                                                               |
| `theme:format.youtubeVideoId`  | Returns the videoId from a YouTube Url (a wide range is supported so far)                                                                                                                                                                            |
| `theme:media.youtube`          | A YouTube ViewHelper with 2 modes. Mode 1 renders a ready2use iFrame HTML tag for embedding a YouTube video. Mode 2 makes it possible to hand over the final YouTube url to Fluid. You can write complete custom HTML markup for your YouTube video. |
| `theme:typoScript.constants`   | Retrieve a specific TypoScript constants path and make it available within Fluid (direct or as specific named variable).                                                                                                                             |
| `theme:context:get`            | Returns the current application context which may include possible sub-contexts. E.g. `Production/Live`                                                                                                                                              |
| `theme:context:productionLive` | Returns true if the application context is Production/Live explicitly.                                                                                                                                                                               |

> See [Backend ViewHelpers overview](../Backend/BackendViewHelpers.md)
> for a list of backend specific ViewHelpers.

