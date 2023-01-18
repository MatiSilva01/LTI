<?php
$en = require_once __DIR__."/en.php";
$keys = ["⠁", "⠃", "⠉", "⠙", "⠑", "⠋", "⠛", "⠓", "⠊", "⠚", "⠅", "⠇", "⠍", "⠝", "⠕", "⠏", "⠟", "⠗", "⠎", "⠞". "⠥". "⠧", "⠺", "⠭", "⠽", "⠵"];

function Cipher($chr) {
    global $keys;
    if (!ctype_alpha($chr))
        return $chr;

    $offset = ord(ctype_upper($chr) ? 'A' : 'a');
    return $keys[fmod((ord($chr) + 1 - $offset), 26) - 1];
}

$translation = [];
foreach ($en as $token=>$toTranslate) {
    $tokenArray = str_split($toTranslate);

    $translated = "";
    foreach ($tokenArray as $chr)
        $translated .= Cipher($chr);

    $translation[$token] = $translated;
}

return $translation;
