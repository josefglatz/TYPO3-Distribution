<?php
putenv('TYPO3_CONTEXT=Production/Live');
putenv('TYPO3_CONTEXT=Production/Live/Frontend');
putenv('TYPO3_CONTEXT=Production/Live/Backend');
putenv('TYPO3_CONTEXT=Production/Dev');
putenv('TYPO3_CONTEXT=Production/Staging');
putenv('TYPO3_CONTEXT=Development/Test');
header('X-Robots-Tag: noindex, nofollow, noarchive, noodp');

/*
 * Include this file in your php.ini via `auto_prepend_file` option:
 * auto_prepend_file = /absolute/path/to/prependFile.php
 * Example Mittwald (you get absolute path via `cd && pwd` command when you're logged in via ssh):
 * auto_prepend_file = /home/www/pXXXXXX/html/prepend.php
 *
 * Create file on Mittwald:
 *  touch ~/html/prepend.php && echo -e "<?php\nputenv('TYPO3_CONTEXT=Production/Dev');\nheader('X-Robots-Tag: noindex, nofollow, noarchive');" > ~/html/prepend.php
 *  touch ~/html/prepend.php && echo -e "<?php\nputenv('TYPO3_CONTEXT=Production/Staging');\nheader('X-Robots-Tag: noindex, nofollow, noarchive');" > ~/html/prepend.php
 *  touch ~/html/prepend.php && echo -e "<?php\nputenv('TYPO3_CONTEXT=Production/Live');" > ~/html/prepend.php
 *  touch ~/html/prepend.php && echo -e "<?php\nputenv('TYPO3_CONTEXT=Production/Live/Frontend');" > ~/html/prepend.php
 *  touch ~/html/prepend.php && echo -e "<?php\nputenv('TYPO3_CONTEXT=Production/Live/Backend');" > ~/html/prepend.php
 *
 * Change php option via command in php.ini:
 * sed -i "s|auto_prepend_file =|auto_prepend_file = /home/www/$USER/html/prepend.php|g" /etc/php/php.ini
 *
 */
