<?php
namespace ec_website;

class Ajax {
    
    public function autoComplete() {
     
      if(isset($_POST['search_window_input'])){
        if (!$_POST['search_window_input'] == '') {//emptyの状態で表示させないため
          $ItemSQL = new \ec_website\ItemSQL();
          $result = $ItemSQL->ajax($_POST['search_window_input']);
            foreach ($result as $key) {
              $item_name = $key['item_name'];
              echo "<option value='$item_name'></option>";
            }
          }
      }
    }
    
}
?>