# TYPO3 Distribution

This repository delivers a full configured, bare metal TYPO3 distribution
based on my best practices.

The goal of this package is to give an example of how a TYPO3 project could
be configured and structured. It is updated on a regular basis to reflect the
current developments of TYPO3 CMS.

## Features

* TYPO3 v8 dev-master in Composer mode
* custom composer tasks
* typo3-console support
* PackageStates.php is excluded in git repository
* ext:realurl (helhum/realurl) (with automatic configuration and ready-to-edit-hook configuration)
* Simple dynamic robots.txt
* RealFaviconGenerator.net gulp integration
* Support for heise's shariff (to enable sharing favorite content without compromising visitors privacy)
* Prepared Linkvalidator configuration
* Support for ext:yaml_configuration

### Linkvalidator (sysext)

To enable the linkvalidator, adopt the prepared configuration first to your needs (`EXT:theme/Configuration/TSConfig/Page/General/Linkvalidator.tsc`)
and then add a Linkvalidator Scheduler Task to activate the linkvalidator on a regular base.

### RealUrl

This distribution uses the the rewritten version [2](https://github.com/dmitryd/typo3-realurl). As there are some changes and
new limitations I recommend to read at least [the install section of realurl's wiki](https://github.com/dmitryd/typo3-realurl/wiki/Installing-and-enabling-the-extension).


#### Configuration

Realurl operates in "auto configuration mode". Therefore you don't need to write the realurl configuration manually.
Instead, you can add your desired changes in `EXT:theme/Classes/Hooks/Frontend/Realurl/RealUrlAutoConfiguration.php`.
As already mentioned, read the [realurl v2 manual](https://github.com/dmitryd/typo3-realurl/wiki)! The automatic resulting
configuration is saved to `app/web/typo3conf/realurl_autoconf.php`.

## Tools

### php-cs-fixer

Execute php-cs-fixer: (php-cs-fixer must be already installed)
```bash
cd ./app && php-cs-fixer fix --config-file Build/.php_cs

## alternative:
cd ./app && composer php-cs-fixer
```
(Check app/Build/.php_cs for instructions how to install php-cs-fixer)

### Gulp powered RealFaviconGenerator.net

* Install dependencies `cd ./app/web/typo3conf/ext/theme/Build && npm install`
* Replace dummy favicon with your Favicon `./app/web/typo3conf/ext/theme/Resources/Public/Icons/Favicon/FaviconMaster.svg`
* Configure the task in the gulpfile.js `./app/web/typo3conf/ext/theme/Build/gulpfile.js` ([details and instructions](https://realfavicongenerator.net/favicon/gulp))
* Generate/Update favicon `cd ./app/web/typo3conf/ext/theme/Build && gulp generate-favicon`
* Inject favicon markup `cd ./app/web/typo3conf/ext/theme/Build && gulp inject-favicon-markups`

As the favicon doesn't change often and generation takes some seconds, all the generated files are included in git
repository and could be deployed as-is. The reasons why the favicons are saved in document root are described
[in the realfavicongenerator.net faq section](https://realfavicongenerator.net/faq). 

### Change vendor name

Initially, the vendor is `JosefGlatz`. If you want to change that at all affected places you can run a small script
which can do that for you:

```bash
cd ./Build && ./ChangeVendor.sh YourNewUpperCamelCaseVendorName
```

[Details about the script](app/Build/ChangeVendor.sh)

Additionally, backup files with an suffixed "-e" are created. (You can safely delete them, if the renaming was successful)

## Recommended Tools/Software/Plugins

* PhpStorm
* PhpStorm Plugin DynamicReturnTypePlugin
* PhpStorm Plugin .ignore
* PhpStorm Plugin String Manipulation
* PhpStorm Plugin Shifter
* PhpStorm Plugin Dash (or alternative devdocs.io)
* PhpStorm Plugin PHP composer.json support
* PhpStorm Plugin Markup to SCSS
* PhpStorm Plugin TypoScript Plugin - Enterprise
* PhpStorm Plugin Fluid Plugin - Enterprise
* PhpStorm Plugin EditorConfig
* Git Tower (or GitKraken)
* SequelPro (or HeidiSQL)
* https://www.getpostman.com/ (Easily test APIs, AJAX requests with postman (Chrome App))

## Credits

Thanks for your support, ideas, issues and shared code

* [Georg Ringer](http://www.ringer.it)
* [Volker Kemeter](https://twitter.com/volkizzl)
* [Benjamin Kott](https://twitter.com/benjaminkott)
