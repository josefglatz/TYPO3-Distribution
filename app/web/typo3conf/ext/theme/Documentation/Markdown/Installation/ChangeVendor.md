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


