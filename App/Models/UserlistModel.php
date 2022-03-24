<?php

namespace App\Models;
use PDO;

class UserlistModel extends Model {
    
    public function getUserList() {
        $statement = $this->pdo->prepare("SELECT * FROM Users");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, "App\Entities\UserEntity");
    }
}