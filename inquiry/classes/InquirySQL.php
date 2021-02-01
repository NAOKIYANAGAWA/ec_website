<?php
namespace inquiry; 

class InquirySQL extends PDO {
    
    public function register_inquiry_to_db() {
          
        try {
        $sql = 'insert into inquiry (title, name, email, phone, content) values (:title, :name, :email, :phone, :content)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
          ':title' => $_SESSION['values']['title'],
          ':name' => $_SESSION['values']['name'],
          ':email' => $_SESSION['values']['email'],
          ':phone' => $_SESSION['values']['phone'],
          ':content' => $_SESSION['values']['content']
          ]);
        } catch(Exception $e) {
          print_r($e->getMessage());
    	  exit();
        }
    }
    
}