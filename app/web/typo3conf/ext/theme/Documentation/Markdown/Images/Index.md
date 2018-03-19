Back to [Index](../Index.md)

---

# Handling of Images in TYPO3

This TYPO3 distribution tries to help you as much with image handling in
different situations:

1. [Resize/Process images on upload](#resizeprocess-images-on-upload)
2. [Simplified cropVariants configuration](#simplified-cropvariants-configuration-for-the-table-configuration-array)
   (custom CropVariantsBuilder)
   1. [Custom CropVariants Builder details](CropVariantsBuilder.md)
3. [Centralized configuration for AspectRatio, Cover-/CropArea presets and CropVariant definitions](#centralized-configuration-for-aspectratio-cover-croparea-presets-and-cropvariant-definitions)
4. [Unlocalize crop configuration](#unlocalize-crop-configuration)

---

## Resize/Process images on upload

With the help of Xavier's `EXT:image_autoresize` it's possible to
process images while uploading in the TYPO3 backend. At time of writing
this documentation, the extension supports following features:

* Resize images on upload (based on maxWidth, maxHeight or maxFilesize,
  fileTypes)
* Rotate images on upload (based on image orientation)
* Remove/Keep image metadata on upload
* Convert image format on upload via mapping
* All the features can be limited to specific directories

You found a predefined extConf in
`typo3conf/AdditionalConfiguration.php` and all further configuration
details inside the extension (documentation, files, configuration in
TYPO3 backend).

---

## Simplified cropVariants configuration for the Table Configuration Array

TYPO3 has some really powerful features to allow TYPO3 backend editors
to crop images. You actually have the following possibilities to
configure cropVariants for a field in following contexts (far as I know
and I've use in real world TYPO3 projects):

### Primary usage scenarios

1. Set a *global/default* cropVariants configuration (which is used if
   you do not make a more specific configuration)
2. Set a cropVariants configuration for a *specific field of a specific
   table* (where you optionally can disable the default/global
   cropVariants configuration)
3. Set a cropVariants configuration for a *specific field of a specific
   type of a table* (where you optionally can disable the default/global
   cropVariants configuration)

**I know that may seem confusing - but once you thought through the
options, it makes makes sense for real world scenarios.**

### Additional usage scenarios

1. Set a cropVariants configuration for a *specific field childTca's
   type of a specific table* (where you optionally can disable (parts
   of) the default/global cropVariants configuration)
2. Set a cropVariants configuration for a *specific field childTca's
   type of a specific type of a table* (where you optionally can disable
   (parts of) the default/global cropVariants configuration)

### And what exactly simplifies this TYPO3 distribution?

You can set up default/s
* for aspectRatios
* for coverArea
* for cropAreas
* list of default cropVariants

[A custom CropVariants Builder](CropVariantsBuilder.md) helps you to
write cropVariants configurations based on mentioned defaults with IDE
auto completion intuitively.

---

## Centralized configuration for AspectRatio, Cover-/CropArea presets and CropVariant definitions

All listed defaults/presets can be actually configured as arrays within
`JosefGlatz\Theme\Backend\CropVariants\Defaults` namespace.

>*The actual plan is to make them configurable via a simple yaml file.
([Issue 280](https://github.com/josefglatz/TYPO3-Distribution/issues/280))*

[**Overview of defaults and predefined presets**](DefaultsAndPresets.md)

1. [aspectRatio presets](DefaultsAndPresets.md#predefined-aspectratios)
2. [coverArea presets](DefaultsAndPresets.md#predefined-coverareas)
3. [cropArea presets](DefaultsAndPresets.md#predefined-cropareas)

---

## Unlocalize crop configuration

Unlocalize `sys_file_reference.crop` per default. Most of the time, this
is what I want for translated websites. **Just run `composer uninstall
cmsexperts/unlocalizedcrop` if you want to remove this behaviour and
activate TYPO3 Core's default.**
