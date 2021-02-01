<?php
namespace ec_website;

class CustomHTML {
    
    // index
    // __construct
    // displayRegisteredOptions
    // displayOptions
    // getOptionHTML
    // generateItemListHTML
    // getItemListHTML
    // getImageHTML
    // generateSlideImageHTML
    // getSlideImageHTML
    // custumPriceValue
    
    private $_optionValues;
    private $_option_metaValues;
    
    public function __construct() {
        //全てのオプションの情報をプロパティにセット
        $ItemSQL = new \ec_website\ItemSQL();
        $this->_optionValues = $ItemSQL->getOptionValues();
        $this->_option_metaValues = $ItemSQL->getOption_metaValues();
     }
    //addItemページで表示するオプションを取得
    public function displayRegisteredOptions() {
      $optionValues = $this->_optionValues;
      $option_metaValues = $this->_option_metaValues;
      $this->getOptionHTML($optionValues,$option_metaValues);
    }
    //singleページで表示するオプションを取得
    public function displayOptions($itemId) {
      $ItemSQL = new \ec_website\ItemSQL();
      $optionIds = $ItemSQL->getSingleOptionId($itemId);
      $option_metaValues = $this->_option_metaValues;
      //チェックボックスを表示しないための引数を設定
      $single = true;
      foreach ($optionIds as $optionId) {
          $optionValues = $ItemSQL->getSingleOptionValues($optionId[item_value]);
          $this->getOptionHTML($optionValues, $option_metaValues, $single);
      }
    }
    // オプションを表示するHTMLを生成
    public function getOptionHTML($optionValues,$option_metaValues, $single = null) {
        
      foreach ($optionValues as $value) {
          
          if ($value[option_type] == 'checkbox') {
              echo '<div class="item-wrapper">';
            //   singleページでチェックボックスはいらないので
              if (!isset($single)) {
                echo '<input id="checkbox" class="checkbox" type="checkbox" name="checkbox_option[]" value="'.$value[option_id].'">';
              }
              echo '<label for="option">'.$value['option_name'].'：</label>';
                foreach ($option_metaValues as $meta_value) {
                    if ($value[option_id] == $meta_value[option_id]) {
                        echo '<input type="radio" name="checkbox" value="'.$meta_value[option_value].'">'.$meta_value[option_value];
                    }
                }
              echo '</div>';
          }
          
          if ($value[option_type] == 'select') {
              echo '<div class="item-wrapper">';
              if (!isset($single)) {
                echo '<input id="checkbox" class="checkbox" type="checkbox" name="checkbox_option[]" value="'.$value[option_id].'">';
              }
              echo '<label for="option">'.$value[option_name].'：</label>';
              echo '<select>';
                foreach ($option_metaValues as $meta_value) {
                    if ($value[option_id] == $meta_value[option_id]) {
                       echo '<option value="'.$meta_value[option_value].'">'.$meta_value[option_value].'</option>';
                    }
                }
              echo '</select>';
              echo '</div>';
          }
          
      }

    }//End->displayRegisteredOptions
    
     //HTMLを作成
    public function generateItemListHTML() {
        
        $Item = new \ec_website\Item();
        $itemValues = $Item->getItems();
        $this->getItemListHTML($itemValues);
        
    }//End->displayRegisteredOptions
    
    //itemList.phpで登録したアイテムを表示するためのHTMLを出力
    protected function getItemListHTML($itemValues) {
            
        $setTitle = [];
           
        foreach ($itemValues as $value) {
            $setTitle[] = [
                'ID' => $value[ID],
                '商品ID' => $value[item_id],
                '商品名' => $value[item_name],
                '商品説明' => $value[item_content],
                '価格' => $value[item_price],
                '登録日' => $value[post_date],
                '修正日' => $value[post_modified] 
            ];
        }
        
         foreach ($setTitle as $key => $value) {
             echo '<div class="list-wrapper-sub2">';
             echo '<table>';
             foreach ($value as $key1 => $value1) {
                 echo '<tr>';
                 echo '<th>'.$key1.'</th>';
                 echo '<td>'.$value1.'</td>';
                 echo '</tr>';
             }
             echo '</table>';
             echo '<div class="item-pics">';
                $this->getImageHTML($value[ID]);
             echo '</div>';
             echo '<form action="" method="post">';
             echo '<input type="hidden" name="item-id" value="'.$value[ID].'">';
             echo '<button type="submit" class="button" name="delete-item-button">商品を削除する</button>';
             echo '</form>';
             echo '</div>';
         }

    }//End->getItemListHTML
    
    //imageを表示するHTMLを生成
    protected function getImageHTML($itemId) {
        $ItemSQL = new \ec_website\ItemSQL();
        $imagePasses = $ItemSQL->getImagePasses($itemId);
            foreach ($imagePasses as $imagePass) {
                echo '<img src="'.h($imagePass[item_value]).'">';
            }
    }
    
    public function generateSlideImageHTML($item_id) {
        $ItemSQL = new \ec_website\ItemSQL();
        $image_passes = $ItemSQL->getSlideImagePasses($item_id);
        $this->getSlideImageHTML($image_passes);
    }
    
    //single.phpでスライド写真用にHTMLを出力
    protected function getSlideImageHTML($image_passes) {

        foreach ($image_passes as $image_pass) {
            echo '<li data-thumb="'.$image_pass[item_value].'">';
			echo '<div class="thumb-image"> <img src="'.$image_pass[item_value].'" data-imagezoom="true" class="img-responsive"> </div>';
		    echo '</li>';
        }

    }
    
    public function custumPriceValue($value) {
        $price = number_format($value);
        return '¥'.$price;
    }
    
}