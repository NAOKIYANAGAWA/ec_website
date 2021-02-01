<?php
namespace ec_website\Exceptions;

class InvalidEmail extends \Exception {
    protected $message = '有効なEmailを入力してください';
}

?>
