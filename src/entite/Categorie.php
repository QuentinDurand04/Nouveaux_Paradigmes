<?php
namespace iutnc\hellokant\entite;

use iutnc\hellokant\model\Model;

class Categorie extends Model {
    protected static $table='categorie';
    protected static $idColumn='id';

    public function articles(){
        return $this->has_many('article', 'id_categ');
    }
    
}