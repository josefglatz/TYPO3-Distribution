Back to [Index](../Index.md) / Back to [Images Index](Index.md)

---

# Overview of defaults/predefined presets

All listed defaults/presets can be configured within
[CropVariants.yaml](../../../Configuration/ImageManipulation/CropVariants.yaml).

---

1. [Predefined aspectRatios](#predefined-aspectratios)
2. [Predefined coverAreas](#predefined-coverareas)
3. [Predefined cropAreas](#predefined-cropareas)
4. [List of default cropVariants](#list-of-default-cropvariants)

---

### Predefined aspectRatios

| Key      | Description                                                              |
|:---------|:-------------------------------------------------------------------------|
| `3:1`    | Often used for wide sujet images                                         |
| `2:1`    | Often used for wide sujet images                                         |
| `1.91:1` | Suggested by Facebook (and Twitter) for open graph / twitter card images |
| `16:9`   | Common video standard                                                    |
| `3:2`    | Common D-/SLR format photography                                         |
| `2:3`    | *(portrait)*                                                             |
| `4:3`    | Common point and shoot format photography                                |
| `3:4`    | *(portrait)*                                                             |
| `5:4`    | Common large and medium format photography                               |
| `4:5`    | *(portrait)*                                                             |
| `1:1`    | Square image format                                                      |
| `NaN`    | Free ratio (no ratio limitation)                                         |

> Adjust/Add/Remove aspectRatios to meet your needs

### Predefined coverAreas

| Key           | Usage Scenario                                                                                |
|:--------------|:----------------------------------------------------------------------------------------------|
| `1_1_circle`  | Can be used for square images with CSS `border-radius: 50%` for example.                      |
| `lower_third` | Can be used for images where the lower third of the image area is overlayed by a DOM element. |

> Adjust/Add/Remove coverArea presets to meet your needs

### Predefined cropAreas

| Key       | Description                                     |
|:----------|:------------------------------------------------|
| `default` | Default (biggest possible) (X0, Y0, W1.0, H1.0) |
| `0.75`    | 75% of the selected aspectRatio                 |
| `0.5`     | 50% of the selected aspectRatio                 |
| `0.25`    | 25% of the selected aspectRatio                 |

> Adjust/Add/Remove cropAreas to meet your needs

### List of default cropVariants

The list of default cropVariants contains a simple array with all as
default defined cropVariants for this TYPO3 instance/project. This array
must reflect the cropVariants configuration of `sys_file_reference.crop`
TCA configuration.

| Key       |
|:----------|
| `default` |

> Adjust/Add/Remove aspectRatios to meet your needs. **This array must
> reflect the cropVariants configuration of `sys_file_reference.crop`
> TCA configuration
> [sys_file_reference.php](../../../Configuration/TCA/Overrides/sys_file_reference.php).**

> The list of default cropVariants is actually used if you use
> `disableDefaultCropVariants()` method.

