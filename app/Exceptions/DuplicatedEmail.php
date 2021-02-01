<?php
namespace ec_website\Exceptions;

class DuplicatedEmail extends \Exception {
    protected $message = '入力されたEmailはすでに登録済みです';
}

?>
