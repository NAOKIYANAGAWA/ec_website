<?php

namespace ec_website;

class Controller {
  //エラーを格納
  private $errors;
  //POSTされた値を格納
  private $values;
   
  public function __construct() {
    if (!isset($_SESSION['token'])) {
      $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(16));
    }
  }

  protected function setValues($key, $value) {
    $this->values[$key] = $value;
  }

  public function getValues() {
    return $this->values;
  }

  protected function setErrors($key, $value) {
    // エラーをKeyとvalueで$errorsに代入
    $this->errors[$key] = $value;
    
  }
  
  public function getErrors() {
    // エラーを渡す
    return isset($this->errors) ? $this->errors : '';
  }
  
  //get_object_vars -> 指定したオブジェクトのプロパティを取得
  protected function hasError() {
    // return !empty($this->errors);
    return !empty($this->errors);
  }

   //ログイン状態を確認する
  protected function loginStatus() {
    return isset($_SESSION['user']) && !empty($_SESSION['user']);
  }

//   public function me() {
//     return $this->isLoggedIn() ? $_SESSION['me'] : null;
//   }

}
