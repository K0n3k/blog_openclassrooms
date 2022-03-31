<?php

namespace App\Models;
use PDO;

class LoginModel extends Model {

    public function connectUser(string $user, $password) {
        $statement = $this->pdo->prepare("SELECT * FROM Users WHERE username = $user");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, "App\Entities\UserEntity");
    }

}