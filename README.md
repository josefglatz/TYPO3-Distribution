# TYPO3 Distribution

[![StyleCI](https://styleci.io/repos/66637769/shield?branch=master)](https://styleci.io/repos/66637769/)

This repository delivers a full configured, bare metal TYPO3 distribution
based on my best practices.

The goal of this package is to give an example of how a TYPO3 project could
be configured and structured. It is updated on a regular basis to reflect the
current developments of TYPO3 CMS.

Branch **master**: Support for TYPO3 8.7 LTS

---

## First setup in combination with webdevops/TYPO3-docker-boilerplate and webdevops/vagrant-docker-vm (Ubuntu 14.04 non reverse-proxy magic)

Basically the folder structure of this TYPO3 distribution is built to work with webdevops/TYPO3-docker-boilerplate. It could be used even without it.

### Just a few things to mention

`app/web` is the webserver document root. All files directly in the root of this repo are for git ignoring and handling file within git, CGLs like `.editorconfig` and `dynamicReturnTypeMeta.json` for PhpStorm helper plugin.

### Let's start

1. `git clone --depth=1 https://github.com/webdevops/TYPO3-docker-boilerplate YourProject` Clone TYPO3-docker-boilerplate
1. `git clone --depth=1 https://github.com/josefglatz/TYPO3-Distribution YourProjectTemp` Clone this TYPO3-Distribution
1. `cd YourProject` Navigate to newly created project dir
1. `rsync -av --progress --exclude '/README.md .git .github' ../YourProjectTemp/ ./` Copy necessary files to prior created project
1. `rm -rf ../YourProjectTemp` Remove the temporary folder
1. `ln -s docker-compose.development.yml docker-compose.yml` Now choose your docker-compose file for your development environment
1. Edit your `docker-compose.yml` to your needs. E.g. set your active containers (and proper links) by un-/commenting lines
1. Choose your PHP version and webserver within `Dockerfile.development` just by adopting the value in the line `FROM ` (with one from the values mentioned in the comments above within the same file)
1. Edit environment variables in `etc/environment.development.yml` `etc/environment.yml`.
1. Set the correct path to the web document root (based on project requirements) in `etc/environment.yml` (default: `WEB_DOCUMENT_ROOT=/app/web/`).
1. Set the correct path to the TYPO3 CLI executable (based on your TYPO3 version) in `etc/environment.yml` (e.g. `CLI_SCRIPT=php /app/web/typo3/sysext/core/bin/typo3`).
1. Adopt your php.ini settings for your project within `etc/php/development.ini`
1. To start your environment take care that no other TYPO3-docker-boilerplate is running on your development environment with `docker ps`. If some other of your projects is running navigate to the folder and stop them by running `docker-compose stop`.
1. Start your machines (basically webserver + mysql server) by running `docker-compose up -d` (make sure you're still in the same folder `YourProject`)
1. Open `yourproject.vm/` in the browser - it should show the php info if all is running correct.
1. `rm app/web/index.php` Delete the dummy index.php (which is responsible for the php info) since you know that the webserver works as expected.
1. `cd app` switch to the app folder
1. Now start TYPO3 preparatory work: Ad your proper adjustments to the TYPO3 `composer.json`
1. `cd ./Build && ./ChangeVendor.sh Sup7even` Replace existing namespaces with your own (e.g. your Name `MaxMustermann`)
1. `./ChangeHeaderComment.php by Sup7even Digital - www.supseven.at` Replace the comment within the head of the website.
1. Adjust configuration array `$site` to your needs in `app/web/typo3conf/AdditionalConfiguration.php`
1. Now remove the git remote and create an initial commit `git remote remove origin && git add -A && git commit -m "[TASK] Initial development setup"`
1. `docker exec -it $(docker-compose ps -q app) bash -c 'cd /app && composer install && ./typo3cms install:setup --non-interactive --admin-user-name admin --admin-password adminadmin --site-setup-type no --site-name TYPO3-Distribution'` It's time to install TYPO3
1. Now open `yourproject.vm/typo3` in the browser and login with User `admin` and password `adminadmin`
1. Commit your basic installation `git add -A && git commit -m "[TASK] Initial TYPO3 installation"`
1. Comment out not needed tables in `/app/Build/InstallDefaultDatabaseRecords.sh` and
1. `docker exec -it $(docker-compose ps -q app) bash -c '/app/Build/InstallDefaultDatabaseRecords.sh'` Import default database records via TYPO3 CLI (and the power of ext:yaml_configuration)
1. Reload your TYPO3 backend and familiarize yourself with the TYPO3 instance
1. Add/remove backend users and set strong passwords for all real backend users.
1. Have fun developing another great TYPO3 website!
1. Read on: [First steps](app/web/typo3conf/ext/theme/Documentation/FirstSteps.md)

---

## Features

* TYPO3 v8 dev-master in Composer mode
* custom composer tasks
* typo3-console support
* PackageStates.php is excluded in git repository
* activated extensions are controlled by root composer.json
* easy vendor name change script
* ext:realurl (helhum/realurl) (with automatic configuration and ready-to-edit-hook configuration)
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


### News

With Twitter Bootstrap activated fluid template.


### Additional useful custom icons for the backend

Some useful icons for the backend for e.g. custom content elements, grid elements, ... `EXT:theme/Resources/Public/Icons/Backend`


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
* [Sup7even Digital](http://www.supseven.at)
