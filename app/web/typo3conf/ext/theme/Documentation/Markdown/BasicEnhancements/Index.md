Back to [Index](../Index.md)

---

# Custom enhancements to tables (out-of-the-box)

- [pages](#table-pages)
- [sys_file_reference](#table-sys_file_reference)
- [tt_content](#table-tt_content)

---


## Table `pages`

### New columns

| Column | Title | Description | Excluded |
|--------|-------|-------------|----------|
| `tx_theme_hide_page_heading` | Hide primary heading (H1) | Can be used by integrator for pages where the default H1 shouldn't be rendered in frontend. (E.g. EXT:news plugin detailAction) [Initial commit](https://github.com/josefglatz/TYPO3-Distribution/commit/e4af938c4e63564207b2631e5ab2242996435fd2) | ✔ |
| `tx_theme_link_label` | Linktext for CTAs/Teasers  | Can be used by integrator as a linktext in Call-To-Action/Teaser Elements which links to this page (for more personalized or better "READMORE" buttons) [Initial commit](https://github.com/josefglatz/TYPO3-Distribution/commit/9b61cbd6f188080cba4955b9f29b883ef665b1ec) | ✔ |
| `tx_theme_nav_image` | Navigation Image  | Can be used by integrator in Call-To-Action/Teaser Elements which links to this page. The default cropVariant(s) can be easily overwritten! [Initial commit](https://github.com/josefglatz/TYPO3-Distribution/commit/6ba8185a6ea0be7b074f06244b6a1058d96564b0) | ✔ |
| `tx_theme_opengraph_description` | `og:description`  | | ✔ |
| `tx_theme_opengraph_image` | `og:image` | Following meta tags are generated automatically `og:image:height`, `og:image:width`, `og:image:type`. Support for only one Open Graph image actually. With official suggested image ratio (cropVariant) | ✔ |
| `tx_theme_opengraph_title` | `og:title` | | ✔ |
| `tx_theme_related` | Related Pages | Backend editors can set related page records (could be extended to support other record types). This can be used in the frontend e.g. for displaying related pages/articles. | ✔ |
| `tx_theme_robot_follow` | Follow links on current page | Robots meta tag value `follow`/`nofollow` can be set per page. | ✔ |
| `tx_theme_robot_index` | Index current page | Robots meta tag value `index`/`noindex` can be set per page. | ✔ |
| `tx_theme_sharing_enabled` | Sharing Functionalities | Frontend sharing features can be dis-/enabled per page. E.g. in a condition in your Fluid template. [Initial commit](https://github.com/josefglatz/TYPO3-Distribution/commit/c38706b864cf205fd451dcbcddb7d7bcd20e5617) | ✔ |
| `tx_theme_show_in_secondary_navigation` | Show Page in Secondary Navigation | Can be used by integrator to not render specific pages in main navigation and instead in meta navigation. [Initial commit](https://github.com/josefglatz/TYPO3-Distribution/commit/1f38003485ecf434ee2149b6013215dc2c2eaf42) | ✔ |
| `tx_theme_twitter_description` | `twitter:description`  | | ✔ |
| `tx_theme_twitter_image` | `twitter:image` | With official suggested image ratio (cropVariant) | ✔ |
| `tx_theme_twitter_title` | `twitter:title` | | ✔ |



## Table `sys_file_reference`

### Customized existing columns

| Column | Title | Description | Excluded |
|--------|-------|-------------|----------|
| `link` (core field) | Unnecessary link field `class` removed |  | - |
| `crop` (core field) | Overwrite core's default cropVariants | The default cropVariants are overwritten. Set you default cropVariants for your project in EXT:theme's `/TCA/Overrides/sys_file_reference.php`. | - |



## Table `tt_content`

### New columns

| Column                | Title                           | Type  | Description                                                        | Excluded |
|:----------------------|:--------------------------------|:------|:-------------------------------------------------------------------|:---------|
| `tx_theme_bodytext_1` | Additional bodytext (RTE) field | text  | Can be used for content elements with more than one bodytext field | -        |
| `tx_theme_bodytext_2` | Additional bodytext (RTE) field | text  | Can be used for content elements with more than one bodytext field | -        |
| `tx_theme_unfolded`   | Initially unfolded              | check | Can be used for content elements with collapsing content           | -        |

### Customized existing columns

| Column | Title | Description | Excluded |
|--------|-------|-------------|----------|
| `header_link` (core) | linkPopup: unnecessary option `class` removed |  | - |


### Additional content element types

| Type                     | Icon                                                                                                                                     | Title                | Description                                                                                                                                                                                                                              |
|:-------------------------|:-----------------------------------------------------------------------------------------------------------------------------------------|:---------------------|:-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `theme_lead_text`        | ![theme-content-text-lead.svg](../../../Resources/Public/Icons/Backend/theme-content-text-lead.svg)                                      | **Lead Text**        | Stand out paragraph especially at the beginning of a page or a section.                                                                                                                                                                  |
| `theme_collapsible_text` | ![theme-content-gridelement-accordion.svg](../../../Resources/Public/Icons/Backend/GridElements/theme-content-gridelement-accordion.svg) | **Collapsible Text** | A regular text element with header (toggle open/close) and bodytext field (toggleable content).                                                                                                                                          |
| `theme_inheritance_stop` | ![theme-content-inheritance-stop.svg](../../../Resources/Public/Icons/Backend/theme-content-inheritance-stop.svg)                        | **Stop inheritance** | Stops the sliding of content elements from upper pages. For a colPos where CEs "slides" from upper pages until any content is placed on a page. (This CE renders nothing in frontend. It just stops the inheritance (as the title says)) |





---

## Footnotes

* "Excluded" means: field has option exclude set to `true`. Such field is available to backend editors (non-admins) only if it was enabled in backend user/-group record.
