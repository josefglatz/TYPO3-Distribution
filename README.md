# TYPO3 Distribution

[![StyleCI](https://styleci.io/repos/66637769/shield?branch=master)](https://styleci.io/repos/66637769/)

This repository delivers a full configured, bare metal TYPO3 distribution
based on my best practices.

The goal of this package is to give an example of how a TYPO3 project could be
configured and structured for real world scenarios. It is updated on a regular
basis to reflect the current developments of TYPO3 CMS.


##### Which TYPO3 version is actually supported?
Branch **master**: TYPO3 8.7 LTS *(regular further development)*

---

## DOCUMENTATION

> The documentation is actually work in progress

- [Introduction](app/web/typo3conf/ext/theme/Documentation/Markdown/Index.md)
- [Installation/Usage](app/web/typo3conf/ext/theme/Documentation/Markdown/Installation/Index.md)
- [Frontend](app/web/typo3conf/ext/theme/Documentation/Markdown/Frontend/Index.md)
- [Backend](app/web/typo3conf/ext/theme/Documentation/Markdown/Backend/Index.md)
- [Basic Enhancements](app/web/typo3conf/ext/theme/Documentation/Markdown/BasicEnhancements/Index.md)
- [CKEditor](app/web/typo3conf/ext/theme/Documentation/Markdown/CKEditor/Index.md)
- [Images](app/web/typo3conf/ext/theme/Documentation/Markdown/Images/Index.md)
- [TYPO3 Extensions](app/web/typo3conf/ext/theme/Documentation/Markdown/Extensions/Index.md)
- [(PhpStorm) Productivity](app/web/typo3conf/ext/theme/Documentation/Markdown/PhpStorm/Index.md)


---

## Some of the Features

* TYPO3 in Composer mode
* Useful custom composer tasks
* helhum/TYPO3-console support
* PackageStates.php is excluded in git repository and written automatically
* activated extensions are controlled by root composer.json
* development context specific extensions are controlled by root composer.json's require-dev section
* Vendor name change script
* Support for ext:yaml_configuration (To import default database records and getting a working fully configured pagetree in just seconds)
* DB-less sys_template record support (no more sys_template records!!!)
* Many TYPO3 backend improvements
    * Support for automatic image resizing when uploading too large images
    * Simplified cropVariants configuration (custom CropVariants Builder)
    * Unlocalized crop configuration (per default – can be disabled)
    * Easy language file editing in the backend [sgalinski/lfeditor](https://packagist.org/packages/sgalinski/lfeditor) (Development context)
    * TYPO3 backend password policies with secure default configuration
    * Additional useful custom icons for the backend
    * Module for listing all registered icon identifiers and showing specific icons as overview
* Many TYPO3 frontend improvements
    * ext:realurl (with both a) automatic configuration and ready-to-edit-hook configuration or b) manual configuration)
    * Simple dynamic robots.txt via eID
    * RealFaviconGenerator.net gulp script
    * Support for Heise's Shariff (to enable sharing favorite content without compromising visitors privacy) via reelworx/rx-shariff
    * Prepared Linkvalidator configuration (TYPO3 core feature)
    * Basic Bootstrap v4 website frontend
    * Simple cookieconsent v3 support (multilanguage)
    * Preconfigured extension georgringer/news

> **Of course, this is just an excerpt** – Get a good overview by browsing the source code and reading the [documentation](app/web/typo3conf/ext/theme/Documentation/Markdown/Index.md).



---




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


