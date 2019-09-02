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
- @TODO: Add info about site configuration
- Set backendLogin logo, color and image in AdditionalConfiguration.php
- add great favicons http://realfavicongenerator.net
- configure linkvalidator scheduler job (receiver email, ...)
- set default language-flags and -name `EXT:theme/Configuration/TsConfig/Page/General/Language.tsconfig.typoscript`
- set all known frontend languages `EXT:theme/Configuration/TypoScript/Tree/Base/constants.txt`
- set ext:static_info_tables default lang (and langs for known alternative languages) `EXT:theme/Configuration/TypoScript/Base/Extensions/StaticInfoTables.constantsts`
- set ext:news default constants `EXT:theme/Configuration/TypoScript/Base/600-Extensions/News/News.constantsts`
- set backend view page module widths to your projectspecific frontend breakpoints
- configure cookie consent (EU cookie law stuff) `EXT:theme/Configuration/TypoScript/Base/Page/CookieLaw.setupts`
- ext:lfeditor: limit available languages in extConf
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

RTFM. With the help of Michiel Roos's extension it's possible to export/import
any table to/from yaml.


### Scheduler tables
```bash
# Scheduler
./typo3cms yaml:export tx_scheduler_task_group /Volumes/CS/Projekte/TYPO3/TYPO3-Distribution/TYPO3-Distribution/app/YamlConfiguration/tx_scheduler_task_group.yaml --force-override
./typo3cms yaml:export tx_scheduler_task /Volumes/CS/Projekte/TYPO3/TYPO3-Distribution/TYPO3-Distribution/app/YamlConfiguration/tx_scheduler_task.yaml
## Default Filemount (normally no need to import as it get's automatically created when installing TYPO3
./typo3cms yaml:export sys_filemounts /Volumes/CS/Projekte/TYPO3/TYPO3-Distribution/TYPO3-Distribution/app/YamlConfiguration/sys_filemounts.yaml
## Backend Users/Groups
./typo3cms yaml:export be_users /Volumes/CS/Projekte/TYPO3/TYPO3-Distribution/TYPO3-Distribution/app/YamlConfiguration/be_users.yaml --skip-columns=uid
./typo3cms yaml:export be_groups /Volumes/CS/Projekte/TYPO3/TYPO3-Distribution/TYPO3-Distribution/app/YamlConfiguration/be_groups.yaml
## Page
./typo3cms yaml:export pages /Volumes/CS/Projekte/TYPO3/TYPO3-Distribution/TYPO3-Distribution/app/YamlConfiguration/pages.yaml
## Page Content
./typo3cms yaml:export tt_content /Volumes/CS/Projekte/TYPO3/TYPO3-Distribution/TYPO3-Distribution/app/YamlConfiguration/tt_content.yaml
./typo3cms yaml:export fe_groups /Volumes/CS/Projekte/TYPO3/TYPO3-Distribution/TYPO3-Distribution/app/YamlConfiguration/fe_groups.yaml
./typo3cms yaml:export fe_users /Volumes/CS/Projekte/TYPO3/TYPO3-Distribution/TYPO3-Distribution/app/YamlConfiguration/fe_users.yaml
## Backend Bookmarks
./typo3cms yaml:export sys_be_shortcuts /Volumes/CS/Projekte/TYPO3/TYPO3-Distribution/TYPO3-Distribution/app/YamlConfiguration/sys_be_shortcuts.yaml --skip-columns=userid
```

#### Running mentioned CLI tasks on macOS with MAMP PRO (Example)

```bash
MYSQL_USER=distri MYSQL_PASSWORD=distri MYSQL_DATABASE=distri MYSQL_PORT=8889 TYPO3_CONTEXT=Development/Mamp /Applications/MAMP/bin/php/php7.1.12/bin/php ./typo3cms export:table ...

MYSQL_USER=distri MYSQL_PASSWORD=distri MYSQL_DATABASE=distri MYSQL_PORT=8889 TYPO3_CONTEXT=Development/Mamp /Applications/MAMP/bin/php/php7.2.8/bin/php ./typo3cms yaml:export
```

###### Make sure to use the correct PHP CLI version

```bash
# Example: using PHP 7.2.1 MAMP PHP CLI binary (you have to install it before via MAMP Pro GUI)
MYSQL_USER=distri MYSQL_PASSWORD=distri MYSQL_DATABASE=distri MYSQL_PORT=8889 TYPO3_CONTEXT=Development/Mamp /Applications/MAMP/bin/php/php7.2.1/bin/php ./typo3cms
```
