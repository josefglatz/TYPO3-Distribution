Back to [Index](../Index.md) / Back to [Backend Index](Index.md)

# Page Module Enhancements

## Custom CSS file

If you build extra ordinary cool backend previews for you content
elements it's often necessary to add custom css styles.

A custom css file
([PageLayoutView.css](../../../Resources/Public/Css/Backend/PageLayoutView.css))
with the usage of the `drawHeaderHook` hook is therefore automatically
included. **Edit the file to your needs!**

> **Tipp:** Prefix your css classes to avoid conflicts with the TYPO3
> Core's default CSS.

## CE Footer: CType info

For me as an integrator it's often hard to see what CType a content element
is.

![pagelayoutview-ce-footer-ctype.png](../../Images/pagelayoutview-ce-footer-ctype.png)

This feature is enabled if on of the scenarios applies:
- The backend user is an administrator
- If it is a development environment
  - `Development/*`
  - `Production/Dev`

> **Info:** You can completely disable the feature via the extension configuration.

## CE Footer: Status badges

The UX for some content elements in the page module can be raised by
adding additional informations – of course, CType specific. In addition
to a meaningful backend preview it's often useful to show the status for
a particular property of the content element like:
- Popup enabled
- Initially unfolded
- Wide/Narrow video with
- ...

### Supported types

| Type  | Description                                  |
|:------|:---------------------------------------------|
| is    | Show badge if value of column is (bool)true  |
| isNot | Show badge if value of column is (bool)false |
| info  | Custom badges (with needs special treatment) |

### Example: How to show a badge if column `tx_theme_unfolded` is true for CType `theme_accordion`

**Extend TCA config for your CType:**

```php
$GLOBALS['TCA']['tt_content']['types']['theme_accordion']['pageLayoutViewEnrichment'] = [
    'footer' => [
        'badges' => [
            'isUnfolded',
        ],
    ],
];
```

**What happens in the background?**

@TODO: TYPO3-Distribution: Add technical background list.

