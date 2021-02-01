<?php
require_once(__DIR__ . '/config/config.php');

$CustomHTML = new \ec_website\CustomHTML();
$Item = new \ec_website\Item();
$Item->deleteItem();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>商品リスト</title>
<link rel="stylesheet" href="css/mycss/itemList.css">
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://kit.fontawesome.com/ffbdaece09.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
</head>
<body>
<p><a href="addItem.php">商品登録</a></p>
<h3>商品リスト一覧</h3>
<div class='list-wrapper'>
   <div class='list-wrapper-sub'>
      <?php $CustomHTML->generateItemListHTML() ?>
   </div>
</div>

</body>
</html>
