<?php
namespace ec_website;

class ItemRegistration {
    
    // index
    // startAddItem
    // getPass_photo
    // registerItem
    // getOption
    // validation

    private $errors;
    private $items;
    
    public function startAddItem() {
    
      if (isset($_POST['addItem-button'])) {
        //登録ボタンが実行されたら登録プロセスを実行
        $id = $this->registerItem();
      }
      
    }
    
    public function getPass_photo() {
    
        $imageUploader = new \ec_website\ImageUploader();
        // var_dump($imageUploader->getImages());
        $images = $imageUploader->getImages();
        
        if (empty($images)) {
          echo '画像がありません';
        } else {
          foreach ($images as $image) {
          $pass = '/images/item_images'.'/' . h(basename($image));
          echo '<li>';
              // echo '<a href="'.'/images/item_images'.'/' . h(basename($image)).'">';
              echo '<img class="uploeaded-image" src="'.h($image).'" title="ダブルクリックで選択">';
              echo '<input type="hidden" name="" value="'.h($pass).'">';
              // echo '</a>';
          echo '</li>';
        }
        }
        
          
    }
    
    protected function registerItem() {
        
        $this->validation();
         
        if ($this->hasError()) {
          return;
        } else {
          //DBへitemを登録するプロセス
          try {
            $itemSQL = new \ec_website\ItemSQL();
            $id = $itemSQL->register([
              'item_id' => $_POST['item_id'],
              'item_name' => $_POST['item_name'],
              'item_price' => $_POST['item_price'],
              'item_content' => $_POST['item_content'],
              'picture_pass' => $_POST['pic-pass']
            ]);
          } catch (\ec_website\Exceptions\DuplicatedItem $e) {
            $this->setErrors('duplicated_item', $e->getMessage());
            return; 
          }
          //オプションが選択されていたらDBへの登録プロセスを実行
          $option = $_POST[checkbox_option];
          if(isset($option)) {
            $itemSQL->registerOption($id,$option);
          }
          unset($_SESSION['item']);
          header('Location: ' . SITE_URL . '/addItem.php');
          exit;
        }
         
    }
    
    // protected function registerOption($optionId) {
    //   $item = new \ec_website\ItemSQL();
    //   $item->registerOptionSQL($optionId);
    // }
    
    protected function getOption() {
      var_dump($_POST['option']);
      exit;
    }
    
    private function validation() {
        
        if (empty($_POST['item_id'])) {
          $this->setErrors('emptyItenId' , '※入力必須です');
          // unset($_SESSION['item']['id']);
        } else {
          $_SESSION['item']['id'] = $_POST['item_id'];
        }
        
        if (empty($_POST['item_name'])) {
          $this->setErrors('emptyItenName' , '※入力必須です');
          // unset($_SESSION['item']['name']);
        } else {
          $_SESSION['item']['name'] = $_POST['item_name'];
        }
        
        if (empty($_POST['item_price'])) {
          $this->setErrors('emptyItenPrice' , '※入力必須です');
          // unset($_SESSION['item']['price']);
        } elseif (!preg_match('/^[0-9]+$/D', $_POST['item_price'])) {
          $this->setErrors('invalidEntry' , '※数字のみ入力してください');
        } else {
          $_SESSION['item']['price'] = $_POST['item_price'];
        }
        
        if (isset($_POST['item_content'])) {
          $_SESSION['item']['content'] = $_POST['item_content'];
        } 
    }
    
    protected function setErrors($key, $value) {
        $this->errors[$key] = $value;
    }
    
    public function getErrors() {
        return isset($this->errors) ? $this->errors : '';
    }
    
    protected function setValues($key, $value) {
        $this->values[$key] = $value;
    }

    public function getValues() {
        return $this->values;
    }
    
    protected function hasError() {
        return !empty($this->errors);
    }
}