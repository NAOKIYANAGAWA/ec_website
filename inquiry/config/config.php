<?php

ini_set('display_errors', 0);

define('SITE_URL', 'https://' . $_SERVER['HTTP_HOST'] . '/inquiry');

require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/autoload.php');

session_start();
