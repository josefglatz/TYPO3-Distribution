#!/usr/local/bin/php
<?php

    if (isset($argv[1])) {
        array_shift($argv);
        $replace_with = implode(' ', $argv);
        echo 'Update config.headerComment to: "' . $replace_with . '"' . PHP_EOL . PHP_EOL;
    } else {
        fwrite(STDOUT, "Please enter new header comment: \n");
        $replace_with=fgets(STDIN);
    }

    $filename='./../web/typo3conf/ext/theme/Configuration/TypoScript/Base/Config.setupts';
    $string_to_replace = 'Based on the TYPO3 Distribution by Josef Glatz https://github.com/jousch/TYPO3-Distribution';
    replace_string_in_file($filename, $string_to_replace, $replace_with);

    function replace_string_in_file($filename, $string_to_replace, $replace_with)
    {
        $content=file_get_contents($filename);
        $content_chunks=explode($string_to_replace, $content);
        $content=implode($replace_with, $content_chunks);
        file_put_contents($filename, $content);
    }
?>
