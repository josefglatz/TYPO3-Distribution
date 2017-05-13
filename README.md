# TYPO3 Distribution

This repository delivers a full configured, bare metal TYPO3 distribution
based on my best practices.

The goal of this package is to give an example of how a TYPO3 project could
be configured and structured. It is updated on a regular basis to reflect the
current developments of TYPO3 CMS.

## Installation/First-setup in combination with webdevops/TYPO3-docker-boilerplate and webdevops/vagrant-docker-vm (Ubuntu 14.04 non reverse-proxy magic)

1. Clone TYPO3-docker-boilerplate `git clone https://github.com/webdevops/TYPO3-docker-boilerplate YourProject`
1. Clone this TYPO3-Distribution `git clone https://github.com/jousch/TYPO3-Distribution YourProjectTemp`
1. Navigate to newly created project dir `cd YourProject`
1. Copy necessary files to prior created project `rsync -av --progress --exclude '/README.md .git' ../TestBoilerplateTemp/ ./`
1. Remove the temporary folder `rm -rf ../YourProjectTemp`
1. Now choose your docker-compose file for your development environment: `ln -s docker-compose.development.yml docker-compose.yml`
1. Set your active containers (and proper links) by un-/commenting lines in `docker-compose.yml`
1. Choose your PHP version and webserver within `Dockerfile.development` just by adopting the value in the line `FROM ` (with one fromm the values mentioned in the comments above within the same file)
1. To start your environment take care that no other TYPO3-docker-boilerplate is running on your development environment with `docker ps`. If some other of your projects is running navigate to the folder and run `docker-compose stop`
1. Start your machines aka lamp (basically webserver + mysql server) by running `docker-compose up -d` (make sure you're still in the same folder `YourProject`)
1. Open `yourproject.vm/` in the browser - it should show the php info if all is running correct.
1. Delete the dummy index.php (which is responsible for the php info) `rm app/web/index.php`
1. `cd app`
1. Let's switch to TYPO3 stuff: Ad your proper adjustments to the TYPO3 `composer.json`
1. Replace exisiting namespaces with your own: `cd ./Build && ./ChangeVendor.sh YourNewUpperCamelCaseVendorName`
1. Replace the comment within the head of the website: `cd ./Build && ./ChangeHeaderComment.php by Sup7even Digital`
1. Remove the remote git repo and do an initial commit `git remote remove origin && git add -A && git commit -m "[TASK] Initial development setup"`
1. After you finished your adjustments save the file and run a `composer install`
1. It's time to install TYPO3 by adding an empty file within the web root `touch web/FIRST_INSTALL`
1. No open `yourproject.vm/` in the browser once more and follow the install steps
1. Commit your installation `git add -A && git commit -m "[TASK] Initial TYPO3 installation"`

@TODO: Import default database structure

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
