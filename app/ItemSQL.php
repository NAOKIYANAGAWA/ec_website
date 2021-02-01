<?php
namespace ec_website;

class ItemSQL extends \ec_website\PDO {
  
  //index
  // register
  // registerOption
  // getItemsSQL
  // getSingleItemSQL
  // delteItemSQL
  // registerOptionToSQL
  // getOptionValues
  // getOption_metaValues
  // getItemOption
  // delteOptionSQL
  // getSingleOptionId
  // getSingleOptionValues
  // getImagePasses
  // getImageSinglePass
  // getSlideImagePasses
  
  //アイテムをDBに登録
  public function register($items) {
    // アイテムの重複チェック
    $stmt = $this->db->prepare("select * from items where item_id = :item_id");
    $stmt->execute([
      ':item_id' => $items['item_id']
    ]);
    $result = $stmt->fetchAll();
    //重複したアイテムがあれば例外を投げる
    if (count($result) > 0) {
      throw new \ec_website\Exceptions\DuplicatedItem();
    } else {
    // DBへ商品を登録
    $sql = 'insert into items (item_content, item_name, item_price, post_date, post_modified, item_id) 
                       values (:item_content, :item_name, :item_price, now(), now(), :item_id)';
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
       ':item_content' => $items['item_content'],
       ':item_name' => $items['item_name'],
       ':item_price' => $items['item_price'],
       ':item_id' => $items['item_id']
      ]);
    }
    
    //ここから画像パスを格納するプロセス
    //上で登録したアイテムのIDが必要なので取得
      $stmt = $this->db->prepare("select ID from items where item_id = :item_id");
      $stmt->execute([
        ':item_id' => $items['item_id']
      ]);
      $id = $stmt->fetch();

    //item_metaに画像パスを格納するプロセス
    if (isset($items['picture_pass'])) {

      //item_metaに画像パスを格納するプロセス
      $sql = 'insert into item_meta (item_id, item_key, item_value) 
                             values (:item_id, :item_key, :item_value)';
      $stmt = $this->db->prepare($sql);
      $picsPass = array_filter( $items['picture_pass'], "strlen" ) ;

      foreach ($picsPass as $key => $value) {
        $stmt->execute([
          ':item_id' => $id[ID],
          ':item_key' => 'picture_pass',
          ':item_value' => $value
          ]);
      }
    }
    //item_metaにオプションを登録する為に$id返す
    return $id;
  }
  
  //選択されたオプションをitem_metaに格納
  public function registerOption($id,$option) {
    
    $sql = 'insert into item_meta (item_id, item_key, item_value) values (:item_id, :item_key, :item_value)';
    $stmt = $this->db->prepare($sql);
    foreach ($option as $key => $value) {
        $stmt->execute([
          ':item_id' => $id[ID],
          ':item_key' => 'option_id',
          ':item_value' => $value
          ]);
      }

  }
  
  //全アイテム情報を取得
  public function getItemsSQL() {
    
    $stmt = $this->db->prepare("select * from items");
    $stmt->execute();
    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    //登録されたアイテムがない場合は例外を投げる
    if (count($result) == 0) {
      throw new \ec_website\Exceptions\NotFoundedItem();
    } else {
      return $result;
    }
    
  }
  
  //アイテム単体の情報を取得
  public function getSingleItemSQL($id) {
    
    $stmt = $this->db->prepare("select * from items where ID = ?");
    $stmt->execute([
      $id['item_id']
    ]);
    $result = $stmt->fetchAll();
    //登録されたアイテムがない場合は例外を投げる
    if (count($result) == 0) {
      throw new \ec_website\Exceptions\NotFoundedItem();
    } else {
      return $result;
    }
    
  }
 
 //アイテムを削除
 public function delteItemSQL($item_id) {
  $stmt = $this->db->prepare('DELETE FROM items WHERE ID = :item_id');
  foreach ($item_id as $key => $value) {
    $stmt->execute([':item_id' =>$value]);
  }

 }
 
  //オプションをDBに登録
  public function registerOptionToSQL($values) {

    // オプションの重複チェック
    $stmt = $this->db->prepare("select * from options where option_name = :option_name");
    $stmt->execute([
      ':option_name' => $values['option_name']
    ]);
    $result = $stmt->fetchAll();
    //オプションが重複していなければ処理を実行、していれば例外を投げる
    if (count($result) > 0) {
      throw new \ec_website\Exceptions\DuplicatedOptionName();
    } else {
    // optionテーブルへ項目を追加する
    $sql = 'insert into options (option_name, option_type) 
                          values (:option_name, :option_type)';
    $stmt = $this->db->prepare($sql);
    $stmt->execute([
      ':option_name' => $values['option_name'],
      ':option_type' => $values['option_type']
      ]);
    }
    
    //上で登録したオプショのIDを取得
      $stmt = $this->db->prepare("select option_id from options where option_name = :option_name");
      $stmt->execute([
        ':option_name' => $values['option_name']
      ]);
      $option_id = $stmt->fetch();

      //option_metaにオプショ値を格納するプロセス
      $sql = 'insert into option_meta (option_id, option_key, option_value) 
                             values (:option_id, :option_key, :option_value)';
      $stmt = $this->db->prepare($sql);
      $option_value = array_filter( $values['option_value'], "strlen" ) ;

      foreach ($option_value as $key => $value) {
        $stmt->execute([
          ':option_id' => $option_id[option_id],
          ':option_key' => $values['option_name'],
          ':option_value' => $value
          ]);
      }
  }
  
  //オプション情報を取得
  public function getOptionValues() {
    $stmt = $this->db->prepare("select * from options");
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }
  
  //オプション情報を取得
  public function getOption_metaValues() {
    //テーブルを結合して値を取得
    $sql = 'SELECT options.option_id,options.option_name,option_meta.option_value,options.option_type
                                    FROM options
                                    INNER JOIN option_meta
                                    ON options.option_id = option_meta.option_id';
    $sth = $this->db->query($sql);
    return $sth->fetchAll(\PDO::FETCH_ASSOC);
  }
 
 //
 public function getItemOption($itemId) {
  // var_dump($itemId);
  // exit;
   $stmt = $this->db->prepare("select item_value from item_meta where item_key = :item_key");
    $stmt->execute([
      ':item_key' => $itemId['item_id']
    ]);
    $result = $stmt->fetchAll();
    
    foreach ($result as $value) {
      $result = explode(",", $value['item_value']);
    }
    
    return $result;
    // var_dump($result);
    // exit;
    
 }
 
// オプションを削除(Item.php)
 public function delteOptionSQL($option_id) {
   
  $stmt = $this->db->prepare('DELETE FROM options WHERE option_id = :option_id');
  foreach ($option_id as $key => $value) {
     foreach ($value as $value1) {
        $stmt->execute([':option_id' =>$value1]);
     }
   }

 }
 //アイテムに登録されているオプションIDを取得
 public function getSingleOptionId($itemId) {
    $stmt = $this->db->prepare("select item_value from item_meta where item_id = :item_id and item_key = 'option_id'");
    $stmt->execute([
      ':item_id' => $itemId
    ]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
 }
 
 //singleページでオプションを表示するための値を取得
 public function getSingleOptionValues($optionId) {
    $stmt = $this->db->prepare("select * from options where option_id = :option_id");
    $stmt->execute([
    ':option_id' => $optionId
    ]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
 
  //全てのイメージパスを取得(CustomHTML.php)
  public function getImagePasses($itemId) {
    $stmt = $this->db->prepare("select item_value from item_meta where item_id = :item_id and item_key = 'picture_pass'");
    $stmt->execute([
      ':item_id' => $itemId
    ]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
 }
 
  //イメージパスを取得(item.php)
  public function getImageSinglePass($itemId) {
    $stmt = $this->db->prepare("select item_value from item_meta where item_id = :item_id and item_key = 'picture_pass' limit 1");
    $stmt->execute([
      ':item_id' => $itemId
    ]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
 }
 
 //スライド写真用イメージパスを取得(CustomHTML.php)
  public function getSlideImagePasses($itemId) {
    $stmt = $this->db->prepare("select item_value from item_meta where item_id = :item_id and item_key = 'picture_pass'");
    $stmt->execute([
      ':item_id' => $itemId
    ]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
 }
 
 public function ajax($value) {
      $sql = ("select item_name from items where item_name like ? limit 10");
      $stmt = $this->db->prepare($sql);
      //like文でデータを取得する場合<execute(array($_POST['test'] . "%"))>
      $stmt->execute(array("%" . $value . "%"));
      //inputがemptyの場合は表示しない（emptyの場合、全て表示してしまう）
      return $stmt->fetchAll();
 }
 
  //
  public function searchItemSQL($value) {
    $stmt = $this->db->prepare("select * from items where item_name like ?");
    $stmt->execute(array($value . "%"));
    $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    //登録されたアイテムがない場合は例外を投げる
    if (count($result) == 0) {
      throw new \ec_website\Exceptions\NotFoundedItem();
    } else {
      return $result;
    }
    
  }
 
}

?>