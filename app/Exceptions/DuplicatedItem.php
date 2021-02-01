<?php
namespace ec_website\Exceptions;

class DuplicatedItem extends \Exception {
    protected $message = '入力された商品IDはすでに登録済みです';
}

?>
