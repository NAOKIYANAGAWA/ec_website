<?php
require_once(__DIR__ . '/config/config.php');

$addItem = new \ec_website\ItemRegistration();
$addItem->startAddItem();
$Option = new \ec_website\Option();
$Option->registerOption_nain();
$Item = new \ec_website\Item();
$CustomHTML = new \ec_website\CustomHTML();   
$Option->daleteOption();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>商品登録</title>
<link rel="stylesheet" href="css/mycss/addItem.css">
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://kit.fontawesome.com/ffbdaece09.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
</head>
<body>
<p><a href="index.php">HOME</a></p>
<p><a href="itemList.php">商品リスト</a></p>
<p><a href="uploadImage.php">画像アップロード</a></p>
<div class='list-wrapper'>
    <!--商品を追加するフォーム-->
    <form class="form-addItem" action="" method="post">
        <div class='item-wrapper'>
         <p><?= $Option->getErrors()['notSelectedOption'] ?></p>
         <p><?= $addItem->getErrors()['emptyItenId'] ?></p>
         <p><?= $addItem->getErrors()['duplicated_item'] ?></p>
         <label for="item_id" >商品ID：</label>
         <input type="text" name="item_id" value="<?= $_SESSION['item']['id'] ?>">
        </div>
        <div class='item-wrapper'>
         <p><?= $addItem->getErrors()['emptyItenName'] ?></p>
         <label for="item_name" >商品名：</label>
         <input type="text" name="item_name" value="<?= $_SESSION['item']['name'] ?>">
        </div>
        <div class='item-wrapper'>
         <label for="item_content" >商品説明：</label>
         <input type="text" name="item_content" value="<?= $_SESSION['item']['content'] ?>">
        </div>
        <div class='item-wrapper'>
         <p><?= $addItem->getErrors()['emptyItenPrice'] ?></p>
         <p><?= $addItem->getErrors()['invalidEntry'] ?></p>
         <label for="item_price" >商品金額：</label>
         <input type="tel" name="item_price" value="<?= $_SESSION['item']['price'] ?>">
        </div>
        <!--写真を選択-->
        <div class='select-pic'>
          <input type="button" id="button-select-pic" value="写真を選択" name='button-select-pic'>
          <input class='input-pic-pass' type="text" name="pic-pass[]" value="">
          <input class='input-pic-pass' type="text" name="pic-pass[]" value="">
          <input class='input-pic-pass' type="text" name="pic-pass[]" value="">
          <!--<button class='button-select-pic' type='button' name='button-select-pic'>写真を選択</button>-->
        </div>
        <!--登録されているオプションを表示-->
        <p>追加するオプションを選択<p>
         <?php $CustomHTML->displayRegisteredOptions() ?>
        <button type="submit" class="button" name="addItem-button">商品を登録する</button>
        <button type="submit" class="button" name="delete-option-button">選択したオプションを削除する</button>
    </form>
    
   <!--オプションを追加するセクション-->
   <p>オプションを追加する</p>
    <form class="form-addOption" action="" method="post">
        <div class='item-wrapper'>
         <p><?= $Option->getErrors()['emptyOptionName'] ?></p>
         <p><?= $Option->getErrors()['emptyOptionValue'] ?></p>
         <p><?= $Option->getErrors()['emptyOptionType'] ?></p>
         <p><?= $Option->getErrors()['duplicated_option_name'] ?></p>
         <p>例）サイズ</p>
         <label for="item_id" >オプション名：</label>
         <input type="text" name="option_name" value="<?= $_SESSION['option_err']['name'] ?>">
        </div>
        <div class='item-wrapper'>
          <p>例）S、M、L、XL、XXL</p>
         <label for="item_id" >オプション項目：</label>
         <input type="text" name="option_value[]" value="<?= $_SESSION['option_err']['value'][1] ?>">
         <input type="text" name="option_value[]" value="<?= $_SESSION['option_err']['value'][2]?>">
         <input type="text" name="option_value[]" value="<?= $_SESSION['option_err']['value'][3]?>">
         <input type="text" name="option_value[]" value="<?= $_SESSION['option_err']['value'][4]?>">
         <input type="text" name="option_value[]" value="<?= $_SESSION['option_err']['value'][5]?>">
        </div>
        <div class="type">
          <div class='item-wrapper'>
           オプションタイプ:
           <!--<input type="radio" checked="checked" name="option_type" value="text" />テキスト-->
           <input type="radio" name="option_type" value="checkbox" <?php echo $_SESSION['option_err']['type']['checkbex']; ?>>チェックボタン
           <input type="radio" name="option_type" value="select" <?php echo $_SESSION['option_err']['type']['select']; ?>>セレクト
          </div>
          <div>
           <div>
           <p>サンプル）チェックボタン</p>
           <select>
            <option>オプション項目1</option>
            <option>オプション項目2</option>
            <option>オプション項目3</option>
           </select>
          </div>
          <div>
           <p>サンプル）セレクト</p>
           <input type="radio" name="radio1">
           <label>オプション項目1</label>
           <input type="radio" name="radio1">
           <label>オプション項目2</label>
           <input type="radio" name="radio1">
           <label>オプション項目3</label>
          </div>
          </div>
        </div>
        
        
        <button type="submit" class="button" name="addOption-button">オプション項目を追加する</button>
    </form>
   
     
     
</div>

<!--写真選択画面-->
<div id='wrapper-photo-section' class='wrapper-photo-section'>
  <div id='photo-section' class='photo-section'>
   <ul>
    <?php $addItem->getPass_photo(); ?>
   </ul>
   <p class='photo-section-closd'>閉じる</p>
  </div>
</div>

<script>
//ボタンをクリックして写真を表示する
var target = document.body;
target.addEventListener('click', function(e){
 var target_id = document.getElementById('button-select-pic').id;
 var selected_target = e.target.id;
 if(selected_target == target_id){
  var target_section = document.getElementById("wrapper-photo-section");
   target_section.classList.add("show-photo-section");
 }
});

//閉じるを押して写真を非表示
 document.getElementsByClassName('photo-section-closd')[0].onclick = function() {
   var target_section = document.getElementById("wrapper-photo-section");
   target_section.classList.remove("show-photo-section");
};

//画像をダブルクリックするとフォームにパスが入る
var target = document.body;
target.addEventListener('dblclick', function(e){
 //画像をダブルクリックしたらパスをセットする
 var pass = e.target.nextElementSibling.getAttribute('value');
 var num = document.querySelectorAll(".input-pic-pass");

 for (let i = 0; i < num.length; i++) {
   var terget = document.getElementsByName('pic-pass[]')[i].getAttribute('value')
   if(terget==''){
    var terget = document.getElementsByName('pic-pass[]')[i];
    terget.defaultValue = pass ;
    break
   }
 
 }
 
 
// console.log(pass1);
 //ウィンドウを閉じる
 var target_section = document.getElementById("wrapper-photo-section");
   target_section.classList.remove("show-photo-section");
 
});


　
</script>

</body>
</html>
