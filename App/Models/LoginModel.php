<?php

namespace App\Models;
use PDO;

class LoginModel extends Model {

    public function connectUser(string $username, $password) {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE username='$username' AND password='$password'");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, "App\Entities\UserEntity");
    }

}