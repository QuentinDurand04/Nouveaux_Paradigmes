<?php
namespace iutnc\hellokant\model;

use Exception;

class HellokantException extends \Exception{

    public function __invoke(){
        throw new Exception();
    }
}
