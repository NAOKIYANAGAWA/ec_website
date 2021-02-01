<?php
namespace ec_website\Exceptions;

class DuplicatedOptionName extends \Exception {
    protected $message = '入力された項目はすでに登録済みです';
}

?>
