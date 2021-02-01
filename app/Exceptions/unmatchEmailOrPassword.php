<?php
namespace ec_website\Exceptions;

class unmatchEmailOrpassword extends \Exception {
    protected $message = 'Emailとパスワードが一致しません';
}

?>
