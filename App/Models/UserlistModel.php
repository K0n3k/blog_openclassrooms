<?php

namespace App\Models;
use PDO;

class UserlistModel extends Model {
    
    public function getUserList() {
        return $this->read("users");
    }
    
    public function deleteUser(int $id) {
        return $this->delete("users", ["id" => $id]);
    }
    
    public function changeIsAdminUser(int $id, int $isAdmin) {
        return $this->update("users",["id" => $id], ["isAdmin" => $isAdmin]);
    }

    public function changeUserValues(int $id, array $values) {
        if(!empty($values["email"])) {
            $sets["email"] = $values["email"];
        }
        if(!empty($values["password"])) {
            $sets["password"] = password_hash($values["password"], null);
        }
        if(!empty($values["firstname"])) {
            $sets["firstname"] = $values["firstname"];
        }
        if(!empty($values["lastname"])) {
            $sets["lastname"] = $values["lastname"];
        }
        if(empty($sets)) {
            return false;
        }
        return $this->update("users",["id" => $id], $sets);
    }
    
}