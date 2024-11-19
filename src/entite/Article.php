<?php
namespace iutnc\hellokant\entite;

use iutnc\hellokant\model\Model;

class Article extends Model {
    protected static $table='article';
    protected static $idColumn='id';

    public function categories(){
        return $this->belongs_to('categorie', 'id');
    }
    
}
