<?php
namespace ec_website\Exceptions;

class NotFoundedItem extends \Exception {
    protected $message = '登録された商品はありません';
}

?>
