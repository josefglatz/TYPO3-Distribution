Back to [Index](../Index.md)

---

# Backend

> This section is work in progress!!

## Linkvalidator (sysext)

To enable the linkvalidator, adopt the prepared configuration first to your needs (`EXT:theme/Configuration/TSConfig/Page/General/Linkvalidator.tsc`)
and then add a Linkvalidator Scheduler Task to activate the linkvalidator on a regular base.

## RealUrl

This distribution uses the the rewritten version [2](https://github.com/dmitryd/typo3-realurl). As there are some changes and
new limitations I recommend to read at least [the install section of realurl's wiki](https://github.com/dmitryd/typo3-realurl/wiki/Installing-and-enabling-the-extension).

### Configuration

Realurl operates in "manual configuration mode". You have to set up the realurl configuration manually in
`EXT:ext/theme/Resources/Private/Extension/Realurl/ManualConfiguration.php`.

If you want to activate the "auto configuration mode", you have to disable it via realurl's extConf.
You can add your desired changes in `EXT:theme/Classes/Hooks/Frontend/Realurl/RealUrlAutoConfiguration.php` after you've
activated the "auto configuration mode".
As already mentioned, read the [realurl v2 manual](https://github.com/dmitryd/typo3-realurl/wiki)! The automatic resulting
configuration is saved to `app/web/typo3conf/realurl_autoconf.php`.


## News

With Twitter Bootstrap activated fluid template.


## Additional useful custom icons for the backend

Some useful icons for the backend for e.g. custom content elements, grid elements, ... `EXT:theme/Resources/Public/Icons/Backend` and an own backend module to list all registerd icon identifiers.
