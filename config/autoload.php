<?php

spl_autoload_register(function($class) {
  $prefix = 'ec_website\\';
  if (strpos($class, $prefix) === 0) {
    $className = substr($class, strlen($prefix));
    $classFilePass = __DIR__ . '/../app/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($classFilePass)) {
      require $classFilePass;
    }
  }
});

// MyApp
// index.php controller
// MyApp\Controller\index
// -> lib/Controller/Index.php

//[spl_autoload_register]自動でクラスファイルを探しに行ってくれる仕組み
//[strpos] — 文字列内の部分文字列が最初に現れる場所を見つける
//substr — 文字列の一部分を返す

// spl_autoload_register(function($class) {
//   $prefix = 'MyApp\\';
//   if (strpos($class, $prefix) === 0) { //$classで$prefix（'MyApp\\'）が最初に現れる位置が０だったら
//     $className = substr($class, strlen($prefix));
//     $classFilePass = __DIR__ . '/../lib/' . str_replace('\\', '/', $className) . '.php';
//     if (file_exists($classFilePass)) {
//       require $classFilePass;
//     }
//   }
// });
