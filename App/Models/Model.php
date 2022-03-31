<?php

namespace App\Models;
use PDO;

class Model {
    protected $pdo;
    protected $statement;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
    }

}