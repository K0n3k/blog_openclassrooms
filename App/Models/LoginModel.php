<?php

namespace App\Models;

class LoginModel extends Model {

    protected $entity = "App\Entities\UserEntity";
    
    public function connectUser(string $email, string $password) {
        
        $user = $this->read("users", ["email" => $email]);
        if(!empty($user) && password_verify($password, $user[0]->getPassword())) {
            return $user[0];
        }
        return false;
    }

    public function createUser(array $params) {
        if(empty($this->read("users", ["email" => $params["email"]], ["email"]))) {
            return $this->create("users", $params);
        }
        return false;
    }
}