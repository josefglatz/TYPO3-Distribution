# TYPO3 Distribution

[![StyleCI](https://styleci.io/repos/66637769/shield?branch=master)](https://styleci.io/repos/66637769/)

This repository delivers a full configured, bare metal TYPO3 distribution
based on my best practices.

The goal of this package is to give an example of how a TYPO3 project could
be configured and structured. It is updated on a regular basis to reflect the
current developments of TYPO3 CMS.

Branch **master**: Support for TYPO3 8.7 LTS

---

## Open the [DOCUMENTATION](app/web/typo3conf/ext/theme/Documentation/Markdown/Index.md) (work in progress)


---

## Features

* TYPO3 8.7 LTS in Composer mode
* custom composer tasks
* typo3-console support
* PackageStates.php is excluded in git repository
* activated extensions are controlled by root composer.json
* easy vendor name change script
* DB-less sys_template record support (via hook)
* ext:realurl (with both a) automatic configuration and ready-to-edit-hook configuration or b) manual configuration) (manual is set by default)
* Simple dynamic robots.txt
* RealFaviconGenerator.net gulp integration
* Support for heise's shariff (to enable sharing favorite content without compromising visitors privacy)
* Prepared Linkvalidator configuration
* Support for ext:yaml_configuration
* Support for automatic image resizing when uploading too large images.
* Simple cookieconsent v3 support
* Easy language file editing in the backend [sgalinski/lfeditor](https://packagist.org/packages/sgalinski/lfeditor) (Development context)
* TYPO3 backend password policies with secure default configuration
* News extension
* Additional useful custom icons for the backend

### TYPO3 Backend Modifications/Improvements


### Linkvalidator (sysext)

To enable the linkvalidator, adopt the prepared configuration first to your needs (`EXT:theme/Configuration/TSConfig/Page/General/Linkvalidator.tsc`)
and then add a Linkvalidator Scheduler Task to activate the linkvalidator on a regular base.

### RealUrl

This distribution uses the the rewritten version [2](https://github.com/dmitryd/typo3-realurl). As there are some changes and
new limitations I recommend to read at least [the install section of realurl's wiki](https://github.com/dmitryd/typo3-realurl/wiki/Installing-and-enabling-the-extension).

#### Configuration

Realurl operates in "manual configuration mode". You have to set up the realurl configuration manually in
`EXT:ext/theme/Resources/Private/Extension/Realurl/ManualConfiguration.php`.

If you want to activate the "auto configuration mode", you have to disable it via realurl's extConf.
You can add your desired changes in `EXT:theme/Classes/Hooks/Frontend/Realurl/RealUrlAutoConfiguration.php` after you've
activated the "auto configuration mode".
As already mentioned, read the [realurl v2 manual](https://github.com/dmitryd/typo3-realurl/wiki)! The automatic resulting
configuration is saved to `app/web/typo3conf/realurl_autoconf.php`.


### News

With Twitter Bootstrap activated fluid template.


### Additional useful custom icons for the backend

Some useful icons for the backend for e.g. custom content elements, grid elements, ... `EXT:theme/Resources/Public/Icons/Backend` and an own backend module to list all registerd icon identifiers.


### Frontend

This TYPO3-Distribution does not provide an ready frontend out-of-the-box. It is not intended therefore! BUT it provides a fundamental base for integrating your website. All the default database
records helps you to start developing/integrating the frontend of your new TYPO3 website.

**Necessary steps are basically:**

* Finalize your page tree
* Finalize backendLayouts
* Integrate your frontend via Fluid
* Write Scss/Css
* Write Javascript
* Configure Yarn/Gulp setup

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

### Change vendor name and other brand marks

#### Vendor Name

Initially, the vendor is `JosefGlatz`. If you want to change that at all affected places you can run a small script
which can do that for you:

```bash
cd ./Build && ./ChangeVendor.sh YourNewUpperCamelCaseVendorName
```

[Details about the script](app/Build/ChangeVendor.sh)

Additionally, backup files with an suffixed "-e" are created. (You can safely delete them, if the renaming was successful)

#### Head comment

Initially, the `config.headerComment` is mentioning this distribution. If you want to change that you can run a small
script too which change it to your needs (or edit [manually](app/web/typo3conf/ext/theme/Configuration/TypoScript/Base/Config.setupts):

```bash
cd ./Build && ./ChangeHeaderComment.php Your new single lined header comment FTW
```

## Responsive Image preparations

### TCA: Predefined Aspect Ratios

| Key | Description |
| --- | -------------------------- |
| `3:1` | Often used for wide sujet images |
| `2:1` | Often used for wide sujet images |
| `1.91:1` | Suggested by Facebook (and Twitter) for open graph / twitter card images |
| `16:9` | Common video standard |
| `3:2` | Common D-/SLR format photography |
| `2:3` |  |
| `4:3` | Common point and shoot format photography |
| `3:4` |  |
| `5:4` | Common large and medium format photography |
| `4:5` |  |
| `1:1` | Square image format |
| `NaN` | Free ratio (no ratio limitation) |

### TCA: Predefined cropArea Presets

| Key | Description |
| --- | ----------- |
| `default` | Default (biggest possible) (X0, Y0, W1.0, H1.0) |

### Predefined coverAreas

| Key | Usage Scenario |
| `1_1_circle` | Can be used for square images with CSS `border-radius: 50%` for example. |
| `lower_third` | Can be used for images where the lower third of the image area is overlayed by a DOM element. |

## Recommended Tools/Software/Plugins


* Git Tower (or GitKraken)
* SequelPro (or HeidiSQL)
* https://www.getpostman.com/ (Easily test APIs, AJAX requests with postman (Chrome App))

## Credits

Thanks for your contribution, ideas, issues and shared code

* [Georg Ringer](http://www.ringer.it)
* [Volker Kemeter](https://twitter.com/volkizzl)
* [supseven](http://www.supseven.at)
* [Benjamin Kott](https://twitter.com/benjaminkott)
* [Boris Schauer](https://twitter.com/bschauer)
