<?php
namespace ec_website\Exceptions;

class InvalidPassword extends \Exception {
    protected $message = '半角英小文字大文字数字をそれぞれ1種類以上含む8文字以上を入力してください';
}

?>
