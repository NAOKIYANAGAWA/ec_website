<?php
namespace inquiry; 

class PDO {
  
  public $db;

  public function __construct() {
    $dbhost = 'dbinstance.cy31igwz0jl1.us-east-2.rds.amazonaws.com';
    $dbport = '3306';
    $dbname = 'ec_website';
    $charset = 'utf8' ;
    
    $dsn = "mysql:host=$dbhost;port=$dbport;dbname=$dbname;charset=$charset";
    $username = 'naoki';
    $password = 'ronaldo7';
    try {
      $this->db = new \PDO($dsn, $user, $password);
    } catch (\PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }
  
}