<?php
namespace ec_website;

class Signup extends \ec_website\Controller {

public function startSignup() {
  
  $_SESSION['username'] = '';
  $_SESSION['email'] = '';
  
    //ログイン状態を確認
  if ($this->loginStatus()) { 
    //ログイン状態だったらトップページへ
    header('Location: ' . SITE_URL);
    exit;
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //POSTされたらログインプロセスを実行
    $this->SignupProcess();
  }
}
  
protected function SignupProcess() {
    // validate
    $this->validation();

    $this->setValues('email', $_POST['email']);

    if ($this->hasError()) {
      return;
    } else {
      //DBへユーザーを登録するプロセス
      echo 'good';
      exit;
      try {
        $user = new \ec_website\User();
        $user->create([
          'email' => $_POST['email'],
          'password' => $_POST['password'],
          'username' => $_POST['username']
        ]);
      } catch (\ec_website\Exceptions\DuplicatedEmail $e) {
        $this->setErrors('email', $e->getMessage());
        return; 
      }
      //redirect to login
      header('Location: ' . SITE_URL . '/login.php');
      exit;
    }
  }

private function validation() {
  
  // トークンを保有しているかをチェック
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "
      <script>
        confirm('無効なトークンです');
      </script>";
      header('Location: ' . SITE_URL);
      exit;
    }
    // Usernameのフォームが入力されているか
    if (empty($_POST['username'])) {
      $this->setErrors('emptyUsername' , '※ユーザーネームが’入力されていません');
    } else {
      $_SESSION['username'] = $_POST['username'];
    }
    // Emailの形式で入力されているか
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $this->setErrors('InvalidEmail' , '※無効なEmailです');
    } else {
      $_SESSION['email'] = $_POST['email'];
    }
    // 半角英小文字大文字数字をそれぞれ1種類以上含む8文字以上
    if (!preg_match('/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/', $_POST['password'])) {
      $this->setErrors('InvalidPassword' , '※半角英小文字大文字数字をそれぞれ1種類以上含む8文字以上');
    }
    // パスと確認用のパスが一致しているか
    if ($_POST['password'] !== $_POST['password_conf']) {
      $this->setErrors('unmatchPasswordConf' , '※パスワードが一致しません');
    }
    
}

}
 ?>
