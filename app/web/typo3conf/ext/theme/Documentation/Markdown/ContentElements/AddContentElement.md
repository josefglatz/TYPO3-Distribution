Back to [Index](../Index.md) / Back to
[Content Elements Index](Index.md)

---

# Adding a new content element

## Overview of common possible ToDo's for a new content element

1. **PHP TCA**
   1. Label improvements
   2. IRRE improvements
      1. min,max,appearance,type limitation,...
      2. cropVariants Builder
   3. Palettes
   4. Footer badges
   5. "Any" TCA field: extend config.search.andWhere
2. **PageTSConfig**
   1. NCEW config
      1. additional fields to set per default?
      2. additional NCEW item to make generating variants quicker?
   2. New RTE preset necessary?
   3. Set RTE custom preset for this type
   4. specific Tceform.tt_content type specific field
      configuration
3. **TypoScript Setup**
4. **Fluid Integration**
   1. Simple Backend Preview Template
      1. Optional: PageLayout DrawItem hook if simple backend preview is not enough
   2. (Simple) Frontend Template
   3. New ViewHelper (if something could be really improved in Fluid)
5. **PHP FormDataProvider**
   1. specific formEngine modifications for this type (if necessary only!) Consider using PageTSConfig first!!!

## Helper method `\JosefGlatz\Theme\Utility\Tca::getShowitemDefault()`

Some parts of the showitem configuration for CTypes has almost always
same parts. Therefore I added an ultra stupid method to retrieve them
without writing it for every custom content element.
