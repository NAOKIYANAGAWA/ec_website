<?php
namespace ec_website;

class Item extends \ec_website\Controller {

    //index
    // __construct
    // deleteItem
    // deleteItemProccess
    // getItems
    // getSingleItem
    // getSinglePicPass
    
    private $items;

     public function __construct() {
         //全てのアイテムの情報をプロパティにセット
         try {
          $ItemSQL = new \ec_website\ItemSQL();
          $this->items = $ItemSQL->getItemsSQL();
        } catch (\ec_website\Exceptions\NotFoundedItem $e) {
          $this->setErrors('notfounded_item', $e->getMessage());
          return; 
        }
        
     }
    //アイテムを削除
    public function deleteItem() {
      if (isset($_POST['delete-item-button'])) {
        $this->deleteItemProccess();
      }
    }
    //アイテムを削除するプロセス
    protected function deleteItemProccess() {
        
       if ($this->hasError()) {
          return;
        } else {
          $ItemSQL = new \ec_website\ItemSQL();
          $ItemSQL->delteItemSQL([
            'item_id' => $_POST['item-id']
          ]);
        }
    }
    //全てのアイテム情報を取得
    public function getItems() {
        return $this->items;
    }
    
    // アイテム単体の情報を取得
    public function getSingleItem($id) {
        
        try {
          $ItemSQL = new \ec_website\ItemSQL();
          return $ItemSQL->getSingleItemSQL(['item_id'=>$id]);
        } catch (\ec_website\Exceptions\NotFoundedItem $e) {
          $this->setErrors('notfounded_item', $e->getMessage());
          return; 
        }
        
    }
    
    //一覧ページ用のシングルイメージパスを出力(index.php)
    public function getSinglePicPass($ID) {
        $ItemSQL = new \ec_website\ItemSQL();
        $pic_pass = $ItemSQL->getImageSinglePass($ID);
        foreach ($pic_pass as $value) {
            echo $value[item_value];
        }
    }
    
    //検索したアイテムを取得
    public function searchItem() {
      if (isset($_POST['search-button'])) {
        try {
          $ItemSQL = new \ec_website\ItemSQL();
          return $ItemSQL->searchItemSQL($_POST['search_window_input']);
        } catch (\ec_website\Exceptions\NotFoundedItem $e) {
          $this->setErrors('notfounded_item', $e->getMessage());
          return; 
        }
      }
    }
    
}