<?php

namespace iutnc\hellokant\model;

use iutnc\hellokant\query\Query;
use iutnc\hellokant\model\HellokantException;

class Model{
    protected static $table;
    protected static $idColumn = 'id';

    protected $atts = [];

    public function __construct(array $t = null){
        if (!is_null($t)) $this->_atts = $t;
    }

    public function __get(string $name): mixed{
        if (array_key_exists($name, $this->_atts))
            return $this->_atts[$name];
        return null;
    }

    public function __set(string $name, mixed $val): void{
        $this->atts[$name] = $val;
    }

    public function delete(){
        if ($this->atts[static::$idColumn] === null){
            throw new HellokantException();
        }

        return Query::table(static::$table)
            ->where(static::$idColumn, '=', $this->atts[static::$idColumn])
            ->delete();
    }

    public function insert(){
        $id = Query::table(static::$table)
        ->insert($this->atts);
        $this->atts['id'] = $id;
    }

    public static function all() : array {
        $all = Query::table(static::$table)->get();
        $return=[];
        foreach( $all as $m) {
            $return[] = new static($m);
        }
        return $return;
    }

    public function find(int $id) : array {
        //1ère méthode
        $m = Query::table(static::$table)
            ->where(static::$idColumn, '=', $id)
            ->get();
        return $m;

        //2ème méthode
        /*
        $colone = $t[0];
        $operateur = $t[1];
        $valeur = $t[2];
        $m = Query::table(static::$table)
            ->where($colone, $operateur, $valeur)
            ->get();
        */
    }
}
