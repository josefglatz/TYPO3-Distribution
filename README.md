# TYPO3 Distribution (TYPO3 9 LTS is WORK IN PROGRESS)

[![StyleCI](https://styleci.io/repos/66637769/shield?branch=master)](https://styleci.io/repos/66637769/)

This repository delivers a full configured, bare metal TYPO3
distribution based on my best practices.

> The goal of this package is to give an example of how a TYPO3 project
> could be configured and structured for real world scenarios. It is
> updated on a regular basis to reflect the current development of TYPO3
> CMS.

---

## Check this

> **ext:theme of this TYPO3 distribution doesn't work alone! It's
> absolutely not intended for standalone usage!!!**

> **This TYPO3 distribution is an advanced, professional TYPO3
> distribution which requires an all-encompassing TYPO3 know-how.**

---

#### Which TYPO3 version is actually supported?

- TYPO3 9 LTS *(regular further development)*
- TYPO3 8 LTS *(important bugfixes)*

---

## DOCUMENTATION

> The documentation is actually work in progress

- [Overview](app/web/typo3conf/ext/theme/Documentation/Markdown/Index.md)
- [Installation/Usage](app/web/typo3conf/ext/theme/Documentation/Markdown/Installation/Index.md)
- [Frontend](app/web/typo3conf/ext/theme/Documentation/Markdown/Frontend/Index.md)
- [Backend](app/web/typo3conf/ext/theme/Documentation/Markdown/Backend/Index.md)
- [Basic Enhancements](app/web/typo3conf/ext/theme/Documentation/Markdown/BasicEnhancements/Index.md)
- [CKEditor](app/web/typo3conf/ext/theme/Documentation/Markdown/CKEditor/Index.md)
- [Images](app/web/typo3conf/ext/theme/Documentation/Markdown/Images/Index.md)
- [TYPO3 Extensions](app/web/typo3conf/ext/theme/Documentation/Markdown/Extensions/Index.md)
- [(PhpStorm) Productivity](app/web/typo3conf/ext/theme/Documentation/Markdown/PhpStorm/Index.md)
- [Code Quality](app/web/typo3conf/ext/theme/Documentation/Markdown/CodeQuality/Index.md)


---

## Some of the Features

* TYPO3 in Composer mode
* Useful custom composer tasks
* helhum/TYPO3-console support
* PackageStates.php is excluded in git repository and written
  automatically
* activated extensions are controlled by root composer.json
* development context specific extensions are controlled by root
  composer.json's require-dev section
* Vendor name change script
* Support for ext:yaml_configuration (To import default database records
  and getting a working fully configured pagetree in just seconds)
* DB-less sys_template record support (no more sys_template records!!!)
* Many TYPO3 backend improvements
  * Support for automatic image resizing when uploading too large images
  * Simplified cropVariants configuration (custom CropVariants Builder)
  * Unlocalized crop configuration (per default – can be disabled)
  * Easy language file editing in the backend
    [sgalinski/lfeditor](https://packagist.org/packages/sgalinski/lfeditor)
    (Development context)
  * TYPO3 backend password policies with secure default configuration
  * Additional useful custom icons for the backend
  * Module for listing all registered icon identifiers and showing
    specific icons as overview
* Many TYPO3 frontend improvements
  * Quick and ready2use RealFaviconGenerator.net gulp script (just
    upload svg, adjust colors, run tasks, commit favicons and you're
    done)
  * Support for Heise's Shariff (to enable sharing favorite content
    without compromising visitors privacy) via reelworx/rx-shariff
  * Prepared Linkvalidator configuration (TYPO3 core feature)
  * Basic Bootstrap v4 website frontend
  * Simple cookieconsent v3 support (multilanguage)
  * Preconfigured extension georgringer/news

> **Of course, this is just an excerpt** – Get a good overview by
> browsing the source code and reading the
> [documentation](app/web/typo3conf/ext/theme/Documentation/Markdown/Index.md).


