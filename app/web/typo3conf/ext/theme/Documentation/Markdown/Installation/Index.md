Back to [Index](../Index.md)

---

# Installation/Usage options of this TYPO3-Distribution

- [First Words](#first-words)
- [MAMP Pro](#mamp-pro-macos-version)
- [WebDevOps TYPO3-docker-boilerplate](#webdevops-typo3-docker-boilerplate)
- [Any LAMP stack](#any-lamp-stack)

## First Words

My opinion: I think every TYPO3 integrator should maintain its own distribution / base.
Take your distribution always seriously! It makes no sense to over-engineer it, or to add
stuff you never need in the real word. At least the badest thing would be if you build such
distribution once and then you neglect them. Then comes the point in a couple of months: It
has accumulated a lot of old stuff.

And really stupid: if you have a lot of old code/integration that does not even work anymore –
because you treated it like your toilet brush over the years.

> Therefore: **Treat your TYPO3-Distribution like your best friend**

This is also my personal reason, why I don't ship my TYPO3-Distribution as
a TYPO3 "distribution" extension. Apart from that, the maintenance would be more extensive.

## Installation Methods

**Here are some options explained to use this TYPO3-Distribution as a Base for your
TYPO3 project:**


# MAMP Pro macOS version

@TODO

---

# WebDevOps TYPO3-docker-boilerplate

## First setup with webdevops/TYPO3-docker-boilerplate and webdevops/vagrant-docker-vm (Ubuntu 14.04 non reverse-proxy magic (only one running project at a time))

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
1. `cd ./Build && ./ChangeVendor.sh Supseven` Replace existing namespaces with your own (e.g. your Name `MaxMustermann`)
1. `./ChangeHeaderComment.php by supseven - www.supseven.at` Replace the comment within the head of the website.
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
1. Read on: [First steps](../../FirstSteps.md)




## with vagrant-docker-vm Ubuntu 16.04 (with Dory Reverse proxy)

@TODO

## with macOS Dinghy

@TODO

---

# Any other LAMP stack

@TODO
