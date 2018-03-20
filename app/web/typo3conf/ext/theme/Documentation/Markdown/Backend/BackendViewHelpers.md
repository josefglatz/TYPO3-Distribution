Back to [Index](../Index.md) / Back to [Backend Index](Index.md)

---

# Backend ViewHelpers

| Name                            | Purpose of ViewHelper                                                           |
|:--------------------------------|:--------------------------------------------------------------------------------|
| `theme.backend.contentEditLink` | Used in Backend Preview templates to wrap the preview with an record edit link. |

## Namespace declaration

**Variant 1**

In generally you don't have to declare the namespace in your Fluid file.
`theme` is registered globally in TYPO3.

**Variant 2:** in a HTML tag

```html
<html xmlns:f="http://typo3.org/ns/TYPO3/CMS/Fluid/ViewHelpers"
	  xmlns:theme="http://typo3.org/ns/JosefGlatz/Theme/ViewHelpers"
	  data-namespace-typo3-fluid="true">
	
</html>	  
```

**Variant 3:** Curly Braces Declaration
```html
{namespace theme=JosefGlatz\Theme\ViewHelpers}
```
