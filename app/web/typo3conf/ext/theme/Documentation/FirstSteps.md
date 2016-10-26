# First steps WORK IN PROGRESS!!!

- composer install
- Set correct sitename (`AdditionalConfiguration.php::8`)
- Set default email (`AdditionalConfiguration.php::9`)
- Set default email name (`AdditionalConfiguration.php::10`)`
- Set productive install tool password in (`AdditionalConfiguration_Production.php`) and save it in password manager (for colleague)
- Set activated languages and update languages
- make shure productive host can handle utf8 file system and correct system locales are set
- Set sys_domains (1. production domain, 2. staging domain, ..., 10. dev domain)
- Set `TCEMAIN.previewDomain`â€™s (DEV, STAGING, ...)
- Set backendLogin logo, color and image in AdditionalConfiguration.php
- add great favicons http://realfavicongenerator.net
- configure linkvalidator scheduler job (receiver email, ...)
- set default language-flags and -name `EXT:theme/Configuration/TSConfig/Page/General/Language.tsc`
- set all known frontend languages `EXT:theme/Configuration/TypoScript/Tree/Base/constants.txt`
- set ext:static_info_tables default lang (and langs for known alternative languages) `EXT:theme/Configuration/TypoScript/Base/Extensions/StaticInfoTables.constantsts`
- set ext:news default constants `EXT:theme/Configuration/TypoScript/Base/600-Extensions/News/News.constantsts`
- set backend view page module widths to your projectspecific frontend breakpoints

## EXT:yaml_confiugration

RTFM.

```
./typo3cms export:table tx_scheduler_task --include-hidden=true --include-deleted=true --skip-columns=crdate,lastexecution_time,lastexecution_failure,lastexecution_context --file=/app/Build/DefaultDatabaseRecords/tx_scheduler_task.yml
./typo3cms import:table tx_scheduler_task --file=/app/Build/DefaultDatabaseRecords/tx_scheduler_task.yml
```
