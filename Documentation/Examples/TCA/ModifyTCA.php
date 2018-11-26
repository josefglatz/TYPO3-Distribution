<?php

// Force inject alternative page title into title palette after nav_title
$GLOBALS['TCA'][$table]['palettes']['title']['showitem'] = preg_replace_callback(
    '/(title.*?,)/i',
    function ($matches) {
        return $matches[1] . '--linebreak--,tx_theme_alternative_title,';
    },
    $GLOBALS['TCA'][$table]['palettes']['title']['showitem'],
    1
);
