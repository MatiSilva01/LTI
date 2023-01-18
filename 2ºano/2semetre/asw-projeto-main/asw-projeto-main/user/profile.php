<?php
session_start();

// Route profile
if (!isset($_SESSION["user"])) {
    header("Location: /");
} else {
    require_once __DIR__ . '/../volunteer/volunteer.php';
    require_once __DIR__ . '/../institution/institution.php';

    $user = unserialize($_SESSION["user"]);
    if ($user instanceof Voluntario) {
        header("Location: /volunteer/profile.php");
    } else {
        header("Location: /institution/profile.php");
    }
}