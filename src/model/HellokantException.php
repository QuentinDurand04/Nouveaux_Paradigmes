<?php
namespace iutnc\hellokant\model;

class HellokantException extends \Exception{

    public function __construct($message, $code = 0, \Exception $previous = null){
        parent::__construct($message, $code, $previous);
    }
}
