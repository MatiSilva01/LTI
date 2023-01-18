<?php
$en = require_once __DIR__."/en.php";

function Cipher($chr) {
    if (!ctype_alpha($chr))
        return $chr;

    $offset = ord(ctype_upper($chr) ? 'A' : 'a');
    return chr(fmod(((ord($chr) + 1) - $offset), 26) + $offset);
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
