<?php
require_once(__DIR__ . '/config/config.php');

echo 'MY PAGE'.'<br>';

// var_dump($_SESSION['user']);
foreach ($_SESSION['user'] as $key => $value) {
  echo $key.'------>'.$value.'<br>';
//   echo $value.'<br>';
//   echo $value['金額'].'<br>';
}

?>

<p><a href="addItem.php">商品管理</a></p>
<p><a href="signout.php">ログアウトする</a></p>