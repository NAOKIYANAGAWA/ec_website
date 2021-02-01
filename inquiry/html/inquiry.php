<?php
require_once(__DIR__ . '/../config/config.php');

$inquiry = new \inquiry\Inquiry();
$inquiry->submit_inquiry();
?>

<!DOCTYPE html>
 <html lang="ja">
 <head>
   <meta charset="utf-8">
   <title>ホームページ</title>
   <link rel="stylesheet" href="../css/styles.css">
 </head>
 <body>
     <div class='main'>
     <P><?= h($inquiry->getErrors('emptyTitle')); ?></P>
     <P><?= h($inquiry->getErrors('emptyName')); ?></P>
     <P><?= h($inquiry->getErrors('emptyEmail')); ?></P>
     <P><?= h($inquiry->getErrors('InvalidEmail')); ?></P>
     <P><?= h($inquiry->getErrors('emptyPhone')); ?></P>
     <P><?= h($inquiry->getErrors('InvalidPhone')); ?></P>
     <P><?= h($inquiry->getErrors('emptyContent')); ?></P>
         <form method="post">
             <select name="title">
                 <option value='none' selected>問い合わせ内容を選択して下さい</option>
                 <option value='opinion' <?= isset($inquiry->getValues()->opinion) ? h($inquiry->getValues()->opinion) : ''; ?>>ご意見</option>
                 <option value='feedback' <?= isset($inquiry->getValues()->feedback) ? h($inquiry->getValues()->feedback) : ''; ?>>ご感想</option>
                 <option value='other' <?= isset($inquiry->getValues()->other) ? h($inquiry->getValues()->other) : ''; ?>>その他</option>
             </select>
             <input type='text' name='name' placeholder='名前' value='<?= isset($inquiry->getValues()->name) ? h($inquiry->getValues()->name) : h($_SESSION['values']['name']); ?>'>
             <input type='email' name='email' placeholder='Email' value='<?= isset($inquiry->getValues()->email) ? h($inquiry->getValues()->email) : h($_SESSION['values']['email']); ?>'>
             <input type='tel' name='phone' placeholder='電話番号' value='<?= isset($inquiry->getValues()->phone) ? h($inquiry->getValues()->phone) : h($_SESSION['values']['phone']); ?>'>
             <textarea name="content" placeholder='問い合わせ内容'><?= isset($inquiry->getValues()->content) ? h($inquiry->getValues()->content) : h($_SESSION['values']['content']); ?></textarea>
             <input type="hidden" name="token" value="<?=$_SESSION['token']?>">
             <input class='button' name='button' type="submit" value="確認"/>
         </form>
     </div>
 </body>
 </html>