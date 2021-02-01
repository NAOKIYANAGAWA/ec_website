<?php

spl_autoload_register(function($class) {
  $prefix = 'inquiry\\';
  if (strpos($class, $prefix) === 0) {
    $className = substr($class, strlen($prefix));
    $classFilePass = __DIR__ . '/../classes/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($classFilePass)) {
      require $classFilePass;
    }
  }
});