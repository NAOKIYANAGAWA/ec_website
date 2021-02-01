<?php
namespace ec_website;

class Option extends \ec_website\ItemRegistration {
    
    //index
    // daleteOption
    // deleteOptionProccess
    // validateDaleteOption
    // registerOption_nain
    // registerOption_sub
    // validation
    
    public function daleteOption() {
      if (isset($_POST['delete-option-button'])) {
        $this->deleteOptionProccess();
      }
    }
    
    protected function deleteOptionProccess() {
      // print_r($_POST['checkbox_option']);

      $this->validateDaleteOption();
      
       if ($this->hasError()) {
          return;
        } else {
          $ItemSQL = new \ec_website\ItemSQL();
          $ItemSQL->delteOptionSQL([
            'option_id' => $_POST['checkbox_option']
          ]);
        }
    }
    
    protected function validateDaleteOption() {
      if (empty($_POST['checkbox_option'])) {
        $this->setErrors('notSelectedOption' , '※削除するオプションが選択されていません');
      }
    }
    
    //オプションをDBに登録するプロセス
    public function registerOption_nain() {
      if (isset($_POST['addOption-button'])) {
        $this->registerOption_sub();
      }
    }
    
    protected function registerOption_sub() {
        
        $this->validation();
         
        if ($this->hasError()) {
          var_dump($this->getErrors());
          return;
        } else {
          //DBへitemを登録する
          try {
            $ItemSQL = new \ec_website\ItemSQL();
            $ItemSQL->registerOptionToSQL([
              'option_name' => $_POST['option_name'],
              'option_value' => $_POST['option_value'],
              'option_type' => $_POST['option_type']
            ]);
          } catch (\ec_website\Exceptions\DuplicatedOptionName $e) {
            $this->setErrors('duplicated_option_name', $e->getMessage());
            return; 
          }
          //validationでセットしたセッションの破棄
          unset($_SESSION['option_err']);
          header('Location: ' . SITE_URL . '/addItem.php');
          exit;
        }
        
    }
    
    private function validation() {
        
        // エラーの変数を初期化
        $this->setErrors = '';

        //オプション名
        if (empty($_POST['option_name'])) {
          $this->setErrors('emptyOptionName' , '※オプション名入力してください');
          $_SESSION['option_err']['name'] = '';
        } else {
          $_SESSION['option_err']['name'] = $_POST['option_name'];
        } 
        
      // オプション項目
      //空のフォームをカウント
        $num = 0;
        foreach ($_POST['option_value'] as $value) {
          if ($value !== '') {
            $num++;
          }
        }
        // フォームが空ならエラーをセット
        if ($num == 0) {
          $this->setErrors('emptyOptionValue' , '※オプション項目は最低でも１つ必要です');
          unset($_SESSION['option_err']['value']);
        } else {
          // フォームに入力した値を残すためのセッションをセット
          $num = 1;
          foreach ($_POST['option_value'] as $value) {
            $_SESSION['option_err']['value'][$num] = $value;
            $num++;
          }
        } 
        
        // オプションタイプ
        // セッションの初期化
        $_SESSION['option_err']['type']['checkbex'] = '';
        $_SESSION['option_err']['type']['select'] = '';
        
        if (empty($_POST['option_type'])) {
          $this->setErrors('emptyOptionType' , '※オプションタイプを選択してください');
        } elseif ($_POST['option_type'] == 'checkbox') {
          $_SESSION['option_err']['type']['checkbex'] = 'checked';
        } elseif ($_POST['option_type'] == 'select') {
          $_SESSION['option_err']['type']['select'] = 'checked';
        } 
    }
    
}