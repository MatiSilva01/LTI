<?php
// Set lang
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

// PT file is pretty much a dummy file because tokens are already in portuguese
$validLangs = ['pt', 'en', 'emoji', 'caesers', 'braille'];
// TODO joao pedro pais lingua???? sus

// Cookie has lang, so overwrite
if(isset($_COOKIE['i18n'])) {
    $lang = $_COOKIE['i18n'];
}

// lang on cookie or browser lang is invalid
if (!in_array($lang, $validLangs)) {
    $lang = $validLangs[0];
}

// Get translations
$translation = require_once __DIR__."/{$lang}.php";

// Define the _ translate func
if (!function_exists('gettext')) {
    function _($token) {
        global $translation;
        global $lang;

        if (empty($lang) || !array_key_exists($token, $translation)) {
            return $token;
        } else {
            return $translation[$token];
        }
    }
}
