Back to [Index](../Index.md) / Back to [Frontend Index](Index.md)

---

# Gulp powered RealFaviconGenerator.net

For 99% of your projects, you can uploading just the primary favicon
file (as svg), adopt the color values in the gulpfile and run 2 gulp
tasks – voilà, you're done!

## Usage Instructions

1. Install dependencies `cd ./app/web/typo3conf/ext/theme/Build && npm
   install`
2. Replace dummy favicon with your project specific Favicon
   `./app/web/typo3conf/ext/theme/Resources/Public/Icons/Favicon/FaviconMaster.svg`
3. Configure project specific options of the task in the gulpfile.js
   `./app/web/typo3conf/ext/theme/Build/gulpfile.js`
   ([details and instructions](https://realfavicongenerator.net/favicon/gulp))
4. Generate/Update favicon `cd ./app/web/typo3conf/ext/theme/Build &&
   gulp generate-favicon`
5. Inject favicon markup `cd ./app/web/typo3conf/ext/theme/Build && gulp
   inject-favicon-markups`
6. Commit your changes to your VCS
7. DONE

>As the favicon doesn't change often and generation takes some seconds,
>all the generated files are included in git repository and could be
>deployed as-is.

>The reasons why the favicons are saved in document root are described
>[in the realfavicongenerator.net faq section](https://realfavicongenerator.net/faq).

## Technical background

* The whole gulp workflow is made by
  [RealFaviconGenerator.net](https://realfavicongenerator.net/favicon/gulp)
  (Only paths were adopted to the needs of this TYPO3 Distribution)
* Most of the generated files are saved to the web root and devices
  automatically tries to fetch them
* Generated lines for `<HEAD />` are written to
  `EXT:theme/Resources/Private/Partials/Page/Favicon/Dist/RealFavIcon.html`
  and loaded through TypoScript
  `EXT:theme/Configuration/TypoScript/Base/Page/Head.setupts`
  automatically.
