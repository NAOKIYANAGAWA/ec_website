<?php
namespace ec_website;

$_SESSION['username'] = '';

class Login extends \ec_website\Controller {
 
  public function startLogin() {
      //ログイン状態を確認
    if ($this->loginStatus()) { 
      //ログイン状態だったらトップページへ
      header('Location: ' . SITE_URL);
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      //POSTされたらログインプロセスを実行
      $this->loginProcess();
    }
  }

  //ログインプロセス
  protected function loginProcess() {
    
    $this->validation();
    // try {
    //   // 受け取った値のをチェック
    //   $this->validation();
    // } catch (\ec_website\Exceptions\emptyEmailForm $e) {
    //   // 例外を受け取ったらsetErrorsに値を送る
    //   $this->setErrors('email' , $e->getMessage());
    // } catch (\ec_website\Exceptions\emptyPasswordForm $e) {
    //   // 例外を受け取ったらsetErrorsに値を送る
    //   $this->setErrors('password' , $e->getMessage());
    // }
    
    if ($this->hasError()) {
      return;
    } else {
      try {
        $user = new \ec_website\User();
        $user->login([
          'email' => $_POST['email'],
          'password' => $_POST['password']
        ]);
      } catch (\ec_website\Exceptions\UnmatchEmailOrPassword $e) {
        $this->setErrors('login', $e->getMessage());
        return;
      }
      header('Location: ' . SITE_URL);
    }
  }
  
  //ユーザーから受け取った値等のチェック
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

  }

}
 ?>
