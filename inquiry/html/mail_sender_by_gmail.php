<?php
// HPMailer のクラスをグローバル名前空間（global namespace）にインポート
// スクリプトの先頭で宣言する必要があります
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once(__DIR__ . '/config/config.php');

// Composer のオートローダーの読み込み（ファイルの位置によりパスを適宜変更）
require dirname( __FILE__ ).'/php_mailer/vendor/autoload.php';
 
//mbstring の日本語設定
mb_language("japanese");
mb_internal_encoding("UTF-8");
 
// インスタンスを生成（引数に true を指定して例外 Exception を有効に）
$mail = new PHPMailer(true);
 
//日本語用設定
$mail->CharSet = "iso-2022-jp";
$mail->Encoding = "7bit";
// header('Location: ' . SITE_URL . '/inquiry/done.php');
try {
  //サーバの設定
  $mail->SMTPDebug = SMTP::DEBUG_SERVER;  // デバグの出力を有効に（テスト環境での検証用）
  $mail->isSMTP();   // SMTP を使用
  $mail->Host       = 'smtp.gmail.com';  // ★★★ Gmail SMTP サーバーを指定
  $mail->SMTPAuth   = true;   // SMTP authentication を有効に
  $mail->Username   = 'nokyngwfree@gmail.com';  // ★★★ Gmail ユーザ名
  $mail->Password   = 'ozlpnrvuhwtjmxtk';  // ★★★ Gmail パスワード
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // ★★★ 暗号化（TLS)を有効に 
  $mail->Port = 587;  //★★★ ポートは 587 
 
  //受信者設定
  //差出人アドレス, 差出人名 
  $mail->setFrom('nokyngwfree@gmail.com', mb_encode_mimeheader('差出人名')); 
  // 受信者アドレス, 受信者名（受信者名はオプション）
  $mail->addAddress($_SESSION['values']['email'], mb_encode_mimeheader("受信者名")); 
  // 追加の受信者（受信者名は省略可能）
  $mail->addAddress('naoki.yanagawa0601@gmail.com'); 
  //返信用アドレス（差出人以外に必要であれば）
//   $mail->addReplyTo('info@example.com', mb_encode_mimeheader("お問い合わせ"));  
  //Cc 受信者の指定
//   $mail->addCC('someone@example.com'); 
 
  //コンテンツ設定
  $mail->isHTML(true);   // HTML形式を指定
  //メール表題（タイトル）
  $mail->Subject = mb_encode_mimeheader('お問い合わせ'); 
  //本文（HTML用）
  $mail->Body  = mb_convert_encoding($_SESSION['values']['body'],"JIS","UTF-8");  
  //テキスト表示の本文
  $mail->AltBody = mb_convert_encoding('プレインテキストメッセージ non-HTML mail clients',"JIS","UTF-8"); 
 
  $mail->send();  //送信

} catch (Exception $e) {
  echo "メッセージの送信に失敗しました　エラー: {$mail->ErrorInfo}";
  return;
}