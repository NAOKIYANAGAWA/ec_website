<?php
require_once(__DIR__ . '/config/config.php');

if (!function_exists('imagecreatetruecolor')) {
  echo 'GDをインストールしてください';
  exit;
}

$imageUploader = new \ec_website\ImageUploader();

// if (isset($_POST['upload'])) {
//  $imageUploader->upload();
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $imageUploader->upload();
}

list($success, $error) = $imageUploader->getResults();

$images = $imageUploader->getImages();

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>画像アップロード</title>
    <link rel="stylesheet" href="css/mycss/uploadImage.css">
  </head>
  <body>
    
    <p><a href="addItem.php">商品登録</a></p>
    
    <form enctype="multipart/form-data" action="" method="POST">
      <div class="file-up">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo h(MAX_FILE_SIZE); ?>" />
        <input name="image" type="file" />
      </div>
      <div class="submit">
        <input type="submit" value="アップロード" class="btn" />
      </div>
    </form>
    
    <?php if (isset($success)) : ?>
      <div class="msg success"><?php echo h($success); ?></div>
    <?php endif; ?>
    <?php if (isset($error)) : ?>
      <div class="msg error"><?php echo h($error); ?></div>
    <?php endif; ?>
    
    <div class='wrapper-image-outer'>
      <ul>
        <?php foreach ($images as $image) : ?>
          <li>
            <!--<div class='wrapper-img';>-->
              <a href="<?php echo '/images/item_images' . '/' . h(basename($image)); ?>">
                <img src="<?php echo h($image); ?>">
              </a>
            <!--</div>-->
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    
  </body>
</html>


