<?php

namespace iutnc\hellokant\model;

class Model
{
    protected static $table;
    protected static $idColumn = 'id';

    protected $atts = [];

    public function __construct(array $t = null){
        if (!is_null($t)) $this->_atts = $t;
    }

    public function __get(string $name): mixed{
        if (array_key_exists($name, $this->_atts))
            return $this->_atts[$name];
    }

    public function __set(string $name, mixed $val): void{
        $this->atts[$name] = $val;
    }
}
