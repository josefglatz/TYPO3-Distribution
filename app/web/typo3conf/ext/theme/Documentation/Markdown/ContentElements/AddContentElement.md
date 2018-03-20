Back to [Index](../Index.md) / Back to
[Content Elements Index](Index.md)

---

# Adding a new content element

## Overview

1. PHP TCA
2. PageTSConfig NCEW config
3. TypoScript Setup
4. Fluid Integration
5. Simple Backend Preview Template
6. PageTSConfig RTE custom preset configuration
7. PageTSConfig: specific Tceform.tt_content type specific field
   configuration
8. PHP: FormDataProvider: specific formEngine modifications for this
   type
9. Optional: PageLayout DrawItem hook if simple backend preview is not enough

## Helper method `\JosefGlatz\Theme\Utility\Tca::getShowitemDefault()`

Some parts of the showitem configuration for CTypes has almost always
same parts. Therefore I added an ultra stupid method to retrieve them
without writing it for every custom content element.
