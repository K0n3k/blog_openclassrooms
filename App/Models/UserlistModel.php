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

}