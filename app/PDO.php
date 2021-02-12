<?php
namespace ec_website;

class PDO {
  
  public $db;

  public function __construct() {
    $dbhost = '';
    $dbport = '3306';
    $dbname = 'ec_website';
    $charset = 'utf8' ;
    
    $dsn = "mysql:host=$dbhost;port=$dbport;dbname=$dbname;charset=$charset";
    $username = 'naoki';
    $password = '';
    try {
      $this->db = new \PDO($dsn, $username, $password);
    } catch (\PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }
  
}
