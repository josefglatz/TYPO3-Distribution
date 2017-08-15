# First steps WORK IN PROGRESS!!!

- delete non required extensions/packages from app/composer.json
- delete extConf settings in AdditionalConfiguration of extensions which you deleted in the previous step
- composer install
- Set correct sitename (`~AdditionalConfiguration.php::8`)
- Set default email (`~AdditionalConfiguration.php::9`)
- Set default email name (`~AdditionalConfiguration.php::10`)`
- Set productive install tool password and save hash in (`AdditionalConfiguration_Production.php`). Don't forget to save it in password manager (e.g. for colleagues)
- Set activated languages and update/retrive them
- make sure that productive host can handle utf8 file system and correct system locales are set
- Set sys_domains (1. production domain, 2. staging domain, ..., 10. dev domain)
- Set `TCEMAIN.previewDomain` (DEV, STAGING, ...)
- Set backendLogin logo, color and image in AdditionalConfiguration.php
- add great favicons http://realfavicongenerator.net
- configure linkvalidator scheduler job (receiver email, ...)
- set default language-flags and -name `EXT:theme/Configuration/TSConfig/Page/General/Language.tsc`
- set all known frontend languages `EXT:theme/Configuration/TypoScript/Tree/Base/constants.txt`
- set ext:static_info_tables default lang (and langs for known alternative languages) `EXT:theme/Configuration/TypoScript/Base/Extensions/StaticInfoTables.constantsts`
- set ext:news default constants `EXT:theme/Configuration/TypoScript/Base/600-Extensions/News/News.constantsts`
- set backend view page module widths to your projectspecific frontend breakpoints
- configure cookie consent (EU cookie law stuff) `EXT:theme/Configuration/TypoScript/Base/Page/CookieLaw.setupts`
- ....

## Cookie Consent

Basically it's just FLUIDTEMPLATE. It comes with https://cookieconsent.insites.com/ v3 support. The fact that it's just a bunch of TypoScript and Fluid makes it easy to pretty easy adopt it to your needs (e.g. if you don't want to use another solution).

Under the hood? An inline javascript is included with `page.jsFooterInline`. Some settings could be set through TypoScript constants. The inline javascript code is rendered via `FLUIDTEMPLATE`. An explicit cache key (TYPO3 caching framework) is used to get better performance and an independent lifetime. The cache key is basically sticked to the rootpage uid and the frontend language. You can adopt the cache key configuration to your needs - e.g. if you don't have additional frontend languages.


- `EXT:theme/Configuration/TypoScript/Base/Page/CookieLaw.setupts`
- `EXT:theme/Configuration/TypoScript/Sites/SiteDefault/constants.txt`

See https://www.cookiechoices.org/ for more informations.

## EXT:image_autoresize

RTFM and update the configuration to your needs.

## EXT:News

## EXT:yaml_confiugration

RTFM. With the help of Michiel Roos's extension it's possible to export/import backend/frontend-/-user/-groups and theoretically
any other table to/from yaml.


### Scheduler tables
```bash
## Scheduler
./typo3cms export:table tx_scheduler_task_group --include-hidden=true --include-deleted=false --skip-columns=crdate,tstamp,cruser_id --file=/app/Build/DefaultDatabaseRecords/tx_scheduler_task_group.yml
./typo3cms import:table "tx_scheduler_task_group" "uid" "/app/Build/DefaultDatabaseRecords/tx_scheduler_task_group.yml"
./typo3cms import:table "tx_scheduler_task_group" "groupName" "/app/Build/DefaultDatabaseRecords/tx_scheduler_task_group.yml" # if https://github.com/MaxServ/t3ext-yaml-configuration/issues/19 is fixed

./typo3cms export:table tx_scheduler_task --include-hidden=true --include-deleted=true --skip-columns=crdate,lastexecution_time,lastexecution_failure,lastexecution_context --file=/app/Build/DefaultDatabaseRecords/tx_scheduler_task.yml
./typo3cms import:table "tx_scheduler_task" "uid" "/app/Build/DefaultDatabaseRecords/tx_scheduler_task.yml"


## Default Filemount (normally no need to import as it get's automatically created when installing TYPO3
./typo3cms export:table sys_filemounts --include-hidden=true --include-deleted=false --skip-columns=tstamp --file=/app/Build/DefaultDatabaseRecords/sys_filemounts.yml
./typo3cms import:table "sys_filemounts" "uid" "/app/Build/DefaultDatabaseRecords/sys_filemounts.yml"


## Backend User/-group
./typo3cms export:backendgroups --include-hidden=true --include-deleted=false --skip-columns=tstamp,crdate,cruser_id,hide_in_lists --file=/app/Build/DefaultDatabaseRecords/be_groups.yml
./typo3cms import:backendgroups "uid" "/app/Build/DefaultDatabaseRecords/be_groups.yml"

./typo3cms export:backendusers --include-hidden=true --include-deleted=false --skip-columns=uid,tstamp,crdate,cruser_id,lastlogin,tx_news_categorymounts,lfeditor_change_editing_modes,tx_besecurepw_lastpwchange --file=/app/Build/DefaultDatabaseRecords/be_users.yml
./typo3cms import:backendusers "username" "/app/Build/DefaultDatabaseRecords/be_users.yml"


## Page
./typo3cms export:table pages --include-hidden=true --include-deleted=false --skip-columns=tstamp,crdate,cruser_id,SYS_LASTCHANGED,tx_impexp_origuid,tx_ddgooglesitemap_lastmod --file=/app/Build/DefaultDatabaseRecords/pages.yml
./typo3cms import:table "pages" "uid" "/app/Build/DefaultDatabaseRecords/pages.yml"


## Page Content
./typo3cms export:table tt_content --include-hidden=true --include-deleted=false --skip-columns=tstamp,crdate,cruser_id --file=/app/Build/DefaultDatabaseRecords/tt_content.yml
./typo3cms import:table "tt_content" "uid" "/app/Build/DefaultDatabaseRecords/tt_content.yml"


## Domain
./typo3cms export:table sys_domain --include-hidden=true --include-deleted=false --skip-columns=tstamp,crdate,cruser_id --file=/app/Build/DefaultDatabaseRecords/sys_domain.yml
./typo3cms import:table "sys_domain" "uid" "/app/Build/DefaultDatabaseRecords/sys_domain.yml"


## Frontend user/-group
./typo3cms export:frontendgroups --include-hidden=true --include-deleted=false --skip-columns=tstamp,crdate,cruser_id --file=/app/Build/DefaultDatabaseRecords/fe_groups.yml
./typo3cms import:frontendgroups "uid" "/app/Build/DefaultDatabaseRecords/fe_groups.yml"

./typo3cms export:frontendusers --include-hidden=true --include-deleted=false --skip-columns=uid,tstamp,crdate,cruser_id,lastlogin --file=/app/Build/DefaultDatabaseRecords/fe_users.yml
./typo3cms import:frontendusers "username" "/app/Build/DefaultDatabaseRecords/fe_users.yml"


## Backend Bookmarks
./typo3cms export:table sys_be_shortcuts --include-hidden=true --include-deleted=false --skip-columns=userid --file=/app/Build/DefaultDatabaseRecords/sys_be_shortcuts.yml
./typo3cms import:table "sys_be_shortcuts" "uid" "/app/Build/DefaultDatabaseRecords/sys_be_shortcuts.yml"
```
