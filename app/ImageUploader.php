<?php

namespace ec_website;

class ImageUploader {

  private $_imageFileName;
  private $_imageType;

  public function upload() {
    try {
      $this->_validateUpload();

      $ext = $this->_validateImageType();

      $savePath = $this->_save($ext);

      $this->_createThumbnail($savePath);

      $_SESSION['success'] = 'アップロードに成功しました';
    } catch (\Exception $e) {
      $_SESSION['error'] = $e->getMessage();
      // exit;
    }
    header('Location:' . SITE_URL . '/uploadImage.php');
    // echo IMAGES_DIR;
    exit;
  }

  public function getResults() {
    $success = null;
    $error = null;
    if (isset($_SESSION['success'])) {
      $success = $_SESSION['success'];
      unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
      $error = $_SESSION['error'];
      unset($_SESSION['error']);
    }
    return [$success, $error];
  }

  public function getImages() {
    $images = [];
    $files = [];
    $imageDir = opendir(IMAGES_DIR);
    //$imageDirにファイルファある間は処理を行う
    while (false !== ($file = readdir($imageDir))) {
      if ($file === '.' || $file === '..') {
        continue;
      }
      // $filesにファイルを格納していく
      $files[] = $file;

      if (file_exists(THUMBNAIL_DIR . '/' . $file)) {
        $images[] = basename(THUMBNAIL_DIR) . '/' . $file;
      } else {
        $images[] = basename(IMAGES_DIR) . '/' . $file;
      }
    }

    array_multisort($files, SORT_DESC, $images);
    return $images;
  }

//getimagesize -> 指定した画像のサイズ・形式を取得する関数
//->取得した画像のサイズ・形式を配列で返す
  private function _createThumbnail($savePath) {
    $imageSize = getimagesize($savePath);
    $width = $imageSize[0];//画像の横幅
    $height = $imageSize[1];//画像の高さ
    if ($width > THUMBNAIL_WIDTH) {//アップロードした画像の幅が設定したサイズより大きい場合はリサイズ
      $this->_createThumbnailMain($savePath, $width, $height);
    }
  }

//imagecreatefromgif —> 新しい画像をファイルあるいは URL から作成
//imagecreatetruecolor —> TrueColor イメージを新規に作成する
  private function _createThumbnailMain($savePath, $width, $height) {
    switch ($this->_imageType) {//画像形式を判別
      case IMAGETYPE_GIF:
        $srcImage = imagecreatefromgif($savePath);
        break;
      case IMAGETYPE_JPEG:
        $srcImage = imagecreatefromjpeg($savePath);
        break;
      case IMAGETYPE_PNG:
        $srcImage = imagecreatefrompng($savePath);
        break;
    }
    $thumbHeight = round($height * THUMBNAIL_WIDTH / $width);//数値を四捨五入
    $thumbImage = imagecreatetruecolor(THUMBNAIL_WIDTH, $thumbHeight);//TrueColor イメージを新規に作成
    imagecopyresampled($thumbImage, $srcImage, 0,0,0,0, THUMBNAIL_WIDTH, $thumbHeight, $width, $height);//再サンプリングを行いイメージの一部をコピー、伸縮する

//imagegif — 画像をブラウザあるいはファイルに出力する
    switch ($this->_imageType) {//リサイズしたファイルを指定したフォルダへ保存
      case IMAGETYPE_GIF:
        imagegif($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
        break;
      case IMAGETYPE_JPEG:
        imagejpeg($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
        break;
      case IMAGETYPE_PNG:
        imagepng($thumbImage, THUMBNAIL_DIR . '/' . $this->_imageFileName);
        break;
    }

  }

//sprintf -> 指定のフォーマットを作成
//sha1 -> 入力されたデータに対して、適当な値を返してくれる関数
//uniqid -> 現在時刻にもとづいたユニークなIDを生成する関数
//mt_rand -> 乱数を生成
//move_uploaded_file -> ファイルの保存場所を変更する
//move_uploaded_file ( アップロードしたファイルのファイル名 , ファイルの移動先 ):

  //ファイル名を設定
  private function _save($ext) {
    $this->_imageFileName = sprintf(
      '%s_%s.%s',
      time(),
      sha1(uniqid(mt_rand(), true)),
      $ext
    );
    //保存先
    $savePath = IMAGES_DIR . '/' . $this ->_imageFileName;
    $res = move_uploaded_file($_FILES['image']['tmp_name'], $savePath);
    if ($res === false) {
      throw new \Exception('ファイルをアップロードできませんでした');
    }
    return $savePath;
  }

  //画像の形式をチェック
  private function _validateImageType() {
    //exif_imagetype->画像の形式を判別し、定数またはFalseを返す
    $this->_imageType = exif_imagetype($_FILES['image']['tmp_name']);
    switch($this->_imageType) {
      case IMAGETYPE_GIF:
      return 'gif';
      case IMAGETYPE_JPEG:
      return 'jpg';
      case IMAGETYPE_PNG:
      return 'png';
      default:
        throw new \Exception('PNG/JPEG/GIF以外はアップロードできません');
    }
  }


  private function _validateUpload() {
    // var_dump($_FILES);
    // exit;

    if (!isset($_FILES['image']) || !isset($_FILES['image']['error'])) {
      throw new \Exception('アップロードに失敗しました');
    }
    //エラーがある場合の処理
    //     UPLOAD_ERR_OK
    // 値: 0; エラーはなく、ファイルアップロードは成功しています。
    // UPLOAD_ERR_INI_SIZE
    // 値: 1; アップロードされたファイルは、php.ini の upload_max_filesize ディレクティブの値を超えています。
    // UPLOAD_ERR_FORM_SIZE
    // 値: 2; アップロードされたファイルは、HTML フォームで指定された MAX_FILE_SIZE を超えています。
    // UPLOAD_ERR_PARTIAL
    // 値: 3; アップロードされたファイルは一部のみしかアップロードされていません。
    // UPLOAD_ERR_NO_FILE
    // 値: 4; ファイルはアップロードされませんでした。
    // UPLOAD_ERR_NO_TMP_DIR
    // 値: 6; テンポラリフォルダがありません。PHP 5.0.3 で導入されました。
    // UPLOAD_ERR_CANT_WRITE
    // 値: 7; ディスクへの書き込みに失敗しました。PHP 5.1.0 で導入されました。
    // UPLOAD_ERR_EXTENSION
    // 値: 8; PHP の拡張モジュールがファイルのアップロードを中止しました。 どの拡張モジュールがファイルアップロードを中止させたのかを突き止めることはできません。 読み込まれている拡張モジュールの一覧を phpinfo() で取得すれば参考になるでしょう。 PHP 5.2.0 で導入されました。
    switch ($_FILES['image']['error']) {
      case UPLOAD_ERR_OK:
        return true;
      case UPLOAD_ERR_INI_SIZE:
      case UPLOAD_ERR_FORM_SIZE:
        throw new \Exception('ファイルが大きすぎます');
      default:
        throw new \Exception('Err: ' . $_FILES['image']['error']);
    }

  }

}

 ?>
