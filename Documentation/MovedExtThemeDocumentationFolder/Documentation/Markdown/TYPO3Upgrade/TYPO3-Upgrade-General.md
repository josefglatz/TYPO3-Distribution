# TYPO3 Upgrade / General Tipps

## Useful TYPO3 extensions

* https://github.com/IchHabRecht/databaseconnectionscanner

# ChangeLog TYPO3 9 LTS Support

## Necessary steps and migration steps

1. Change logo CE name to `theme_logo_list` [#337](https://github.com/josefglatz/TYPO3-Distribution/issues/337)
2. `be_groups.hide_in_lists` removed from export examples
3. The path `EXT:theme/TSConfig` was renamed to `EXT:theme/TsConfig` [#338](https://github.com/josefglatz/TYPO3-Distribution/issues/338)
4. RTE CKEditor plugin wordcount was removed. It's now shipped by the core and can be used out of the box/core
5. Core packages needs to be re-checked. Not all v8 package is available with 9 LTS

## Enhancements / General changes

1. EXT:gdpr activated per default

