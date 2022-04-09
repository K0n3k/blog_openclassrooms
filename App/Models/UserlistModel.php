<?php

namespace App\Models;
use PDO;

class UserlistModel extends Model {
    
    public function getUserList() {
        return $this->read("users");
    }
}