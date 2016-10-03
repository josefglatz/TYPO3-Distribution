# TYPO3 Distribution

**Documentation is still WIP**

## Features

* TYPO3 v8 dev-master in Composer mode
* custom composer tasks
* typo3-console support
* PackageStates.php is excluded in git repository
* ext:realurl (helhum/realurl) (with automatic configuration and ready-to-edit-hook configuration)
* Simple dynamic robots.txt
* RealFaviconGenerator.net gulp integration


## Tools

### php-cs-fixer

Execute php-cs-fixer: (php-cs-fixer must be already installed)
```bash
cd ./app && php-cs-fixer fix --config-file Build/.php_cs
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

[Details about the script](Build/ChangeVendor.sh)

Additionally, backup files with an suffixed "-e" are created. (You can safely delete them, if the renaming was successful)

## Credits

Thanks for your support, ideas, issues and shared code

* [Georg Ringer](http://www.ringer.it)
* [Volker Kemeter](https://twitter.com/volkizzl)
* [Benjamin Kott](https://twitter.com/benjaminkott)
