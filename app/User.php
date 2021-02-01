<?php

namespace ec_website;

class User extends \ec_website\PDO {
  
  //index
  // create
  // login

  public function create($values) {
    // Emailの重複チェック
    $stmt = $this->db->prepare("select * from users where user_email = :email");
    $stmt->execute([
      ':email' => $values['email']
    ]);
    $result = $stmt->fetchAll();
    // echo count($result);
    // exit;
    if (count($result) > 0) {
      throw new \ec_website\Exceptions\DuplicatedEmail();
    } else {
    // DBへユーザー登録
    $sql = 'insert into users (user_email, user_pass, display_name, user_registered) values (:email, :password, :username, now())';
    $stmt = $this->db->prepare($sql);
    $result = $stmt->execute([
      ':email' => $values['email'],
      ':password' => password_hash($values['password'], PASSWORD_DEFAULT),
      ':username' => $values['username']
    ]);
    }
  }

  public function login($values) {
    $stmt = $this->db->prepare("select * from users where user_email = :email");
    $result = $stmt->execute([//$resultチェック
      ':email' => $values['email']
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();
    if (empty($user)) {
      throw new \ec_website\Exceptions\unmatchEmailOrPassword();
    }
    if (!password_verify($values['password'], $user->user_pass)) {
      throw new \ec_website\Exceptions\unmatchEmailOrPassword();
    }
    // セッションハイジャック対策（セッションIDを再生成）
    session_regenerate_id(true);
    //ユーザー情報をセッションに保存
    $_SESSION["user"] = $user;
  }

}
