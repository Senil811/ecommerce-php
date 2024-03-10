<?php
$visits = 1;

if (isset($_COOKIE['visits'])) {
    $visits = $_COOKIE['visits'] + 1;
}

setcookie('visits', $visits, time() + 3600 * 24 * 30); // Cookie set to expire in 30 days

echo "Welcome to the website! This is visit number $visits.";

?>