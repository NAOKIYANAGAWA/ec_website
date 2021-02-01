<?php
require_once(__DIR__ . '/config/config.php');

$signout = new \ec_website\Signout();
$signout->startSignout();