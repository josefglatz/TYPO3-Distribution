Back to [Index](../Index.md)

---

# CKEditor improvements and defaults

This TYPO3 distribution comes with some really useful real world scenario presets. It also ships some custom modifications
with external plugins and a custom project specific plugin to limit the tables plugin.

> **Extending/Adopting the CKEditor in TYPO3 is much easier and makes more fun – Try it out!**

- [Predefined CKEditor presets](#overview-of-shipped-ckeditor-presets)
- [Custom CKEditor plugins]()

## Overview of shipped CKEditor presets

| Preset key              | Extend from     | Description                                                                       |
|:------------------------|:----------------|:----------------------------------------------------------------------------------|
| `theme_default`         | -               | Default CKEditor configuration                                                    |
| `theme_defaultNoTables` | `theme_default` | Disables table plugin                                                             |
| `theme_minimal`         | -               | Very minimal preset (as a base for other minimal custom project specific presets) |

### The configuration could be found inside `EXT:theme`

- `EXT:theme/Configuration/TSConfig/Page/General/RTE/` → PageTSConfig to assign available presets
- `EXT:theme/Configuration/RTE/` → Every yaml file represents a preset
- `EXT:theme/Configuration/RTE/Additional` → Every yaml file inside this subfolder is inteded to be imported into final CKEditor presets
- `EXT:theme/ext_localconf.php` → `$rtePresets` array reflects all available custom CKEditor presets. (This is where the presets gets registered in TYPO3.)

### theme_defaultNoTables

![ckeditor-preset-theme_defaultNoTables-TYPO3-8LTS.png](../../Images/ckeditor-preset-theme_defaultNoTables-TYPO3-8LTS.png)

