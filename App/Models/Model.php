<?php

namespace App\Models;
use PDO;

class Model {
    protected PDO $pdo;
    protected $entity;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=blog;charset=utf8', 'root', '');
    }

    public function create(string $table, array $values) {
        $statement = $this->pdo->prepare("INSERT INTO $table (" . implode(",", array_keys($values)) . ") VALUES ('" . implode("','", $values) ."')");
        //dd($statement);
        return $statement->execute();
    }

    public function read(string|array $table, ?array $parameters = null, ?array $fields = ["*"]) {
        $quote = "";
        $query = "SELECT ".implode(",", $fields)." FROM ";
        if(is_array($table)) {
            $query .= implode(",", $table) ;
        } else {
            $query .= $table ;
            $quote = "'";
        }
                
        if($parameters !== null) {
            $query .= " WHERE ";
            foreach($parameters as $key => $parameter) {
                $query .= "$key = $quote$parameter$quote";
                if ($key !== array_key_last($parameters)) {
                    $query .= " AND ";
                }
            }
        }
        //dd($query);
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, $this->entity);
    }

    public function update() {

    }

    public function delete(string $table, array $parameters = null) {
        $query = "DELETE FROM $table";
        foreach($parameters as $key => $parameter) {
            $query .= "$key = $parameter";
            if ($key !== array_key_last($parameters)) {
                $query .= " AND ";
            }
        }
        $statement = $this->pdo->prepare($query);
        $statement->execute();
    }

}