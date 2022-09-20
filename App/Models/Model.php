<?php

namespace App\Models;

use App\Entitys\Entity;
use PDO;
use App\Enums\SqlOperators;
use App\Enums\SqlTables;

class Model {
    protected PDO $pdo;
    protected string $query;
    protected $entity;
    protected $placeholder = [];

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host='.$_ENV['DB_HOST'].';dbname='. $_ENV['DB_DATABASE'] .';charset=utf8', $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
    }

    protected function insert(SqlTables $table, Entity $entity) {
        $values = (array)$entity;
        
        foreach($values as $key => $value) {
            $values += [substr_replace($key,"",0,strpos($key,"\x00", 1)+1) => "'".$value."'"];
            $this->placeholder += [":".array_key_last($values) => $value];
            unset($values[$key]);
        }
        
        $this->query = 'INSERT INTO '. $table->name.' (' . implode(',', array_keys($values)) . ') VALUES (' . implode(',', array_keys($this->placeholder)) .')' ;
        $statement = $this->pdo->prepare($this->query);
        foreach($this->placeholder as $phKey => &$phValue) {
            $statement->bindParam($phKey, $phValue);
        }
        $statement->execute();
        unset($this->query);
        unset($this->placeholder);
        return $this->pdo->lastInsertId();
    }

    protected function select(array $table, array $fields = ["*"]) : ?self {
        $this->query = "SELECT " . implode(",", $fields) . " FROM " . implode(",", $table);
        return $this;
    }

    protected function where(string $field, string $value,string $condition = "=", SqlOperators $operator = SqlOperators::AND) : ?self {
        $operator === SqlOperators::AND ? $operator = SqlOperators::AND->name : $operator = SqlOperators::OR->name;
        str_contains($this->query, "WHERE") ? $this->query .= " $operator $field $condition $value" : $this->query .= " WHERE $field $condition $value";
        return $this;
    }

    protected function exec() : array|false {
        $statement = $this->pdo->prepare($this->query);
        //dd($statement);
        foreach($this->placeholder as $phKey => &$phValue) {
            $statement->bindParam($phKey, $phValue);
        }
        $statement->execute();
        unset($this->query);
        unset($this->placeholder);
        return $statement->fetchAll(PDO::FETCH_CLASS, $this->entity);
    }

    protected function update(string $table, array $sets) : ?self {
        $this->query = "UPDATE $table SET ";
        foreach($sets as $setKey => $set) {
            $this->query .= "$setKey = :$setKey ";
            $this->placeholder += [":".$setKey => $set];
            if ($setKey !== array_key_last($sets)) {
                $this->query .= ", ";
            }
        }
        return $this;
    }

    protected function delete(string $table) : ?self {
        $this->query = "DELETE FROM $table";
        return $this;
    }

    protected function sortBy() {
        return $this;
    }

}