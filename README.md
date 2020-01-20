# josefglatz/TYPO3-Distribution

[![StyleCI](https://styleci.io/repos/66637769/shield?branch=master)](https://styleci.io/repos/66637769/)

This repository delivers a full configured, bare metal TYPO3
distribution based on my best practices.

> The goal of this package is to give an example of how a TYPO3 project
> could be configured and structured for real world scenarios. It is
> updated on a regular basis to reflect the current development of TYPO3
> CMS. It's used by me as an advanced TYPO3 boilerplate for real world
> TYPO3 projects.

---

## Check this

> **ext:theme of this TYPO3 distribution doesn't work alone! It's
> absolutely not intended for standalone usage!!!**

> **This TYPO3 distribution is an advanced, professional TYPO3
> distribution which requires an all-encompassing TYPO3 know-how.**

---

#### Which TYPO3 version is actually supported?

- TYPO3 9.5 LTS *(regular further development)*

---

## DOCUMENTATION

> The documentation is actually work in progress

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
  * Simplified cropVariants configuration (custom [CropVariants Builder](https://github.com/josefglatz/cropvariantsbuilder) )
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
