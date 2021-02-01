<?php

ini_set('display_errors', 0);

define('SITE_URL', 'https://' . $_SERVER['HTTP_HOST']);
define('MAX_FILE_SIZE', 1 * 1024 * 1024); //1M
define('THUMBNAIL_WIDTH', 240);
define('IMAGES_DIR', __DIR__ . '/../images/item_images');
define('THUMBNAIL_DIR', __DIR__ . '/../thumbs');

require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/autoload.php');

session_start();
