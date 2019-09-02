Back to [Index](../Index.md)

---

# 3rd Party TYPO3 Extensions

This TYPO3 distribution comes with "many" already activated/configured
TYPO3 extensions. Keep in mind to remove extensions, which you don't
need/want for a specific project.

> **The complete handling of activated aka installed extensions is
> controlled via composer.json's `require`/`require-dev` options!**

- [Default activated extensions](#default-activated-extensions)
- [Suggested extensions](#suggested-extensions)
- [Overview of ready2use preconfigured extensions](#suggested-extensions-with-ready2use-configuration-snippets)

---

## Default activated extensions

| EXT                    | Reason/Description                                                                  | for editor          | for dev/integrator  |
|:-----------------------|:------------------------------------------------------------------------------------|:--------------------|:--------------------|
| autoswitchtolistview   | If page module and a sys folder is selected, a redirect to the list module is done. | :white_check_mark:  | :white_check_mark:  |
| be_secure_pw           | Password rules and Password reminder                                                | :white_check_mark:  | :white_check_mark:  |
| beuser_fastswitch      | Admins can switch to specific backend (test-)editors with just 2 clicks             | :x:                 | :white_check_mark:  |
| content_defender       | Limit colPos's                                                                      | :white_check_mark:  | :white_check_mark:  |
| deprecationloganalyzer |                                                                                     | :x:                 | :white_check_mark:  |
| gdpr                   | GDPR relevant enhancements                                                          | :white_check_mark:  | :white_check_mark:  |
| gravatar               | Backend user gravatar avatar support                                                | :white_check_mark:  | :white_check_mark:  |
| iconcheck              | Overview of custom registered icons for backend users.                              | :x:                 | :white_check_mark:  |
| page_speed             | Google Page Speed Module                                                            | :x:                 | :white_check_mark:² |
| querybuilder           | Backend extension for query builder in list module.                                 | :x:                 | :white_check_mark:  |
| t3monitoring_client    | Client extension for the t3monitoring service                                       | :x:                 | :white_check_mark:  |
| yaml_configuration     | Configure your TYPO3 site using YAML files                                          | :x:                 | :white_check_mark:¹ |

* _¹ Only activated in composer --dev mode_
* _² Only usable if the fronted is reachable from public internet_
* _* EXT:mask is intended to be used along with EXT:mask_export in a
  development context_

---

## Suggested extensions

**All suggested or common optional TYPO3 extensions (in my subjective
opinion) are listed in composer.json's `suggest` option.** Some of them
are already activated – I've use the suggest-option also to keep known
extensions for reference in the list.

## Suggested extensions with ready2use configuration snippets

### `lochmueller/sourceopt`

This distribution ships my best practice configuration
([EXT:theme/Resources/Private/Examples/TypoScript/Sourceopt/](../../../Resources/Private/Examples/TypoScript/Sourceopt))
which you only need to copy to
`EXT:theme/Configuration/TypoScript/Base/Extensions` and require the
extension via composer `composer require lochmueller/sourceopt`
