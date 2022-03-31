<?php

namespace App\Models;
use PDO;

class CommentaryListModel extends Model {
    
    public function getCommentaryList() {
        $statement = $this->pdo->prepare("SELECT * FROM commentary");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, "App\Entities\CommentaryEntity");
    }
}