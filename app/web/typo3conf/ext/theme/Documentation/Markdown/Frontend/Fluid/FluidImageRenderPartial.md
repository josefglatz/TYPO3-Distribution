Back to [Index](../../Index.md) / Back to [Frontend Index](../Index.md)
/ Back to [Fluid Index](Index.md)

# Image Render (Fluid Partial)

> This partial was introduced as a first version to generate
> `<picture/>` HTML tags with `<source />` tags inside and support for
> CSS media query based image widths, image art direction (with TYPO3's
> multiple cropVariant support) and pixel densities.

## Overview

- [Supported arguments](#supported-arguments-see-the-in-depth-documentation-below-for-each-argument)
- [Usage examples](#usage-examples)
- [Historical ChangeLog](#historical-changelog)
- [Further Links](#further-links)

---

## Supported arguments (See the in-depth documentation below for each argument)

| Argument name          | Description                                                                                                                                                                                 | Has Fallback       |
|:-----------------------|:--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|:-------------------|
| `file`                 | `sys_file_reference` / Image reference for the fluid image render partial                                                                                                                   | ❌                 |
| `settings`             | Mainly used in content element context where breakpoints (type specific, type + option specific, project default), pixelDensities (type specific, project default)                          | :white_check_mark: |
| `breakpoints`          | Configuration array for the basic amount of `<source />` HTML tags. (The breakpoints argument is only necessary if you're not configure them in TypoScript `settings.breakpoint`)           | :white_check_mark: |
| `class`                | CSS class for the `<img />` HTML tag. Defaults to `img-fluid`                                                                                                                               | :white_check_mark: |
| `linkClass`            | CSS class for the `<a />` HTML tag around the `<picture />` HTML tag. Defaults to `picturelink`. The tag is only generated if `{file.link}` is set (= if sys_file_reference has a link set) | :white_check_mark: |
| `pictureClass`         | CSS class for the `<picture />` HTML tag. Defaults to "no class".                                                                                                                           | :white_check_mark: |
| `pixelDensities`       | Configuration array for the amount of additional sized images (optimized for desired device pixel ratios)                                                                                   | :white_check_mark: |
| `defaultImageMaxWidth` | Maximum image width for the fallback `<img />` src attribute.                                                                                                                               | :white_check_mark: |
| `defaultCropVariant`   | Used cropVariant for the fallback `<img />` src attribute.                                                                                                                                  | :white_check_mark: |

## Usage examples

> Usage of the fluid partial within a content element is the default for
> examples, if no other context is mentioned explicitly!

### Render image with default sizes

```html
<f:render partial="Content/ImageRender" arguments="{settings: settings, file:image}"/>
```

### Render image with explicit breakpoints configuration

```html
<f:render partial="Content/ImageRender" arguments="{settings: settings, file:file, breakpoints:settings.breakpoints.default}"/>
```

### Render image with explicit breakpoints configuration

```html
<f:render partial="Content/ImageRender" arguments="{settings: settings, file:file, breakpoints:settings.breakpoints.specialconfiguration}"/>
```

### Render image with custom `<img />` HTML tag css class

```html
<f:render partial="Content/ImageRender" arguments="{settings: settings, file:file, class: 'custom-img-tag-css-class'}"/>
```

### Render image with custom `<picture />` HTML tag css class

```html
<f:render partial="Content/ImageRender" arguments="{settings: settings, file:file, pictureClass: 'custom-pciture-tag-css-class'}"/>
```

### Render image where fallback image processing is using the existing cropVariant `lg`

```html
<f:render partial="Content/ImageRender" arguments="{settings: settings, file:file, defaultCropVariant: 'lg'}"/>
```

### Render image where fallback image processing is using a custom defaultImageMaxWidth value

```html
<f:render partial="Content/ImageRender" arguments="{settings: settings, file:file, defaultImageMaxWidth: '1600'}"/>
```

### Render image with custom `{breakpoints}` configuration

```html
<f:variable name="breakpoints" value="{
        0:{media:'max-width', size:375, maxWidth:375, cropVariant:'mobile'},
        1:{media:'max-width', size:480, maxWidth:480, cropVariant:'mobile'},
        2:{media:'max-width', size:767, maxWidth:767, cropVariant:'tablet'},
        3:{media:'max-width', size:991, maxWidth:991, cropVariant:'tablet'},
        4:{media:'max-width', size:1279, maxWidth:1279, cropVariant:'default'},
        5:{media:'max-width', size:1479, maxWidth:1479, cropVariant:'default'},
        6:{media:'min-width', size:1480, maxWidth:2000, cropVariant:'default'}
    }"/>
    
<f:render partial="Content/ImageRender" arguments="{settings: settings, file:image, breakpoints:breakpoints}"/>
```

### Render image with custom `{pixelDensities}` configuration

```html
<f:variable name="pixelDensities" value="{
        0:{media: '2.0', min-resolution: 192}
    }"/>
    
<f:render partial="Content/ImageRender" arguments="{settings: settings, file:image, pixelDensities: pixelDensities}"/>
```

### Render image with custom configuration (non content element context – where no ImageRender specific TypoScript `settings` configuration was defined for fluid rendering)

```html
<f:variable name="pixelDensities" value="{
        0:{media: '2.0', min-resolution: 192}
    }" />
<f:variable name="breakpoints" value="{
        0:{min-ratio: 'min-width', size: theme.breakpoints.xs, maxWidth: 360, cropVariant: 'xs'},
        1:{media: 'min-width', size: theme.breakpoints.md, maxWidth: 340, cropVariant: 'md'},
        2:{media: 'min-width', size: theme.breakpoints.lg, maxWidth: 240, cropVariant: 'lg'}
    }" />
<f:render partial="Content/ImageRender" arguments="{file: NavImages.0, breakpoints:breakpoints, defaultImageMaxWidth: 360, pixelDensities:pixelDensities}" />
```

---

## Historical ChangeLog

### 1. Initial fluid partial which was intended to use with content elements

**Support for**
1. a `<f:link.typolink />` tag around `<picture />` HTML tag (if the
   sys_file_reference has a link set)
   1. The resulting `<a />` HTML tag get's a CSS class `picturelink`
2. fix device pixel ratios (also known as device pixel densities)
   1. factor 1.0 and
   2. 2.0 (retina)
3. breakpoints configuration via `settings.breakpoints` and custom
   `{breakpoints}` argument
   1. and a fallback image with
      1. a fixed default image max width configured in TypoScript
      2. a configurable cropVariant via `{defaultCropVariant}` argument
         and fallback to `default` cropVariant
4. a custom CSS class for the `<img />` tag

### 2. Add additional fixed device pixel ratios

**Extend the previous version with support for many known common device
pixel ratios**
- 1.25 (some Androids)
- 1.3 (some Androids)
- 1.5 (some Androids)
- 2.0 (Retina, already existed)

### 3. Make device pixel ratios configurable

**Extend the previous version with support for**
- default device pixel ratios configuration in TypoScript
  `lib.contentElement`
  - with support for overwriting based on content element type
  - with support for setting the configuration via fluid argument
    `{pixelDensities}` (e.g. if you use the fluid partial in page
    templates)

### 4. Support for set up `defaultImageMaxWidth` via argument

---

## Further links

- Get an overview of real device pixel ratios:
  https://mydevice.io/devices/
