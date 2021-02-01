<?php
require_once(__DIR__ . '/config/config.php');
$inquiry = new \inquiry\Inquiry();
$inquiry->register_inquiry();
?>

<!DOCTYPE html>
 <html lang="ja">
 <head>
   <meta charset="utf-8">
   <title>確認ページ</title>
   <link rel="stylesheet" href="css/styles.css">
 </head>
 <body>
    <div class='confirm_msg'>
        <h3>問い合わせ内容の確認</h3>
        <p>件名：<?= $_SESSION['values']['title'] ?></p>
        <p>お名前：<?= $_SESSION['values']['name'] ?></p>
        <p>メールアドレス：<?= $_SESSION['values']['email'] ?></p>
        <p>電話番号：<?= $_SESSION['values']['phone'] ?></p>
        <p>お問い合わせ内容</p>
        <p><?= $_SESSION['values']['content'] ?></p>
    </div>
    <div class='confirm_btn'>
        <form method="post">
            <input type="hidden" name="token" value="<?=$_SESSION['token']?>">
            <button class='button' type="submit" formaction='inquiry.php'>修正</button>
            <input class='button' name='button_submit' type="submit" value="送信"/>
        </form>
    </div>
 </body>
 </html>