<?php

namespace App\Models;
use PDO;

class BlogpostListModel extends Model {
    
    public function getBlogPostList() {
        $statement = $this->pdo->prepare("SELECT * FROM blogpost");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, "App\Entities\BlogpostEntity");
    }
}