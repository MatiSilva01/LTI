<?php
function sendEmail(string $to, string $subject, string $message) {
    $header = "From: asw21@lucks.pt\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";
    
    mail($to, $subject, $message, $header);
}