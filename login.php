<?php
require_once(__DIR__ . '/config/config.php');

$login = new \ec_website\Login();
$login->startLogin();

 ?>
 <!DOCTYPE html>
 <html lang="jp">

 <head>
 	<title>Login</title>
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
     <h1>Log In</h1>
     <form class="" action="" method="post">
       <p></p>
       <div class="form-item">
         <label for="email"></label>
         <p><?= $login->getErrors()['InvalidEmail'] ?></p>
         <input type="email" name="email" placeholder="Email Address"></input>
       </div>
       <div class="form-item">
         <label for="password"></label>
         <p><?= $login->getErrors()['InvalidPassword'] ?></p>
         <input type="password" name="password" placeholder="Password"></input>
       </div>
       <input type="hidden" name="token" value="<?= h($_SESSION['token'] )?>">
       <p><?= $login->getErrors()['login'] ?></p>
       <div class="button-panel">
         <button type="submit" class="button" name="login-button">Log In</button>
       </div>
     </form>
     <div class="form-footer">
       <p><a href="signup.php">Create an account</a></p>
       <p><a href="#">Forgot password?</a></p>
       <p><a href="index.php">Back to Home</a></p>
     </div>
   </div>

</body>

</html>
