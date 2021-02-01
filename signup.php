<?php
require_once(__DIR__ . '/config/config.php');

$signup = new \ec_website\Signup();
$signup->startSignup();


 ?>
<!--サインイン機能でやること-->

<!--バリデーション-->
<!--
データが入力されているか
データ型があっているか
文字数が上限を超えていないか
決められたルールで入力されているか
ファイル形式があっているか


<!--パスワードをハッシュ化-->
<!--
主にセキュリティ対策
パスワードが漏洩しないようにする
-->

<!--流れ-->
<!--
ユーザー登録フォーム
登録完了画面の作成
バリデーションの作成
ユーザ登録ロジックの作成
ユーザ登録機能の実装
-->

  <!DOCTYPE html>
  <html lang="jp">

  <head>
  	<title>signin</title>
  	<!-- custom-theme -->
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  	<script type="application/x-javascript">
  		addEventListener("load", function () {
  			setTimeout(hideURLbar, 0);
  		}, false);

  		function hideURLbar() {
  			window.scrollTo(0, 1);
  		}
  	</script>
   <link href="css/mystyle.css" rel="stylesheet" type="text/css" media="all" />
  	<!-- font-awesome-icons -->
  	<link href="css/font-awesome.css" rel="stylesheet">
  	<!-- //font-awesome-icons -->
  	<link href="//fonts.googleapis.com/css?family=Montserrat:100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800"
  	    rel="stylesheet">
  	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800" rel="stylesheet">
  </head>

  <body>

    <div class="form-wrapper">
      <h1>Sign Up</h1>
      <form class="" action="" method="post">
        <div class="form-item">
          <label for="username"></label>
          <p><?= $signup->getErrors()['emptyUsername'] ?></p>
          <input type="text" name="username" placeholder="Username" value="<?= $_SESSION['username'] ?>"></input>
        </div>
        <div class="form-item">
          <label for="email"></label>
          <p><?= $signup->getErrors()['InvalidEmail'] ?></p>
          <input type="email" name="email" placeholder="Email Address" value="<?= $_SESSION['email'] ?>"></input>
        </div>
        <div class="form-item">
          <label for="password"></label>
          <p><?= $signup->getErrors()['InvalidPassword'] ?></p>
          <input type="password" name="password" placeholder="Password"></input>
        </div>
        <div class="form-item">
          <label for="password_conf"></label>
          <p><?= $signup->getErrors()['unmatchPasswordConf'] ?></p>
          <input type="password" name="password_conf" placeholder="Confirm Password"></input>
        </div>
        <p><?= $signup->getErrors()['email'] ?></p>
        <input type="hidden" name="token" value="<?= h($_SESSION['token'] )?>">
        <div class="button-panel">
          <button type="submit" class="button" name="signup-button">Register</button>
        </div>
      </form>
      <div class="form-footer">
        <p><a href="login.php">Log In</a></p>
        <p><a href="index.php">Back to Home</a></p>
      </div>
    </div>

 </body>

 </html>
