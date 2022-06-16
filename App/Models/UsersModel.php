<?php

namespace App\Models;

use App\Entitys\UserEntity;
use App\Enums\SqlTables;
use App\Enums\UserFields;

class UsersModel extends Model {
    
    public function __construct() {
        parent::__construct();
        
        $this->entity = "App\Entitys\UserEntity";        
    }
    
    public function createUser(UserEntity $user): UserEntity|false {
    
        $userCheck = $this
            ->select([
                SqlTables::users->name,
            ],[
                UserFields::email->name,
            ])
            ->where(
                UserFields::email->name,
                "'".$user->getEmail()."'",
            )
            ->exec();
    
        return empty($userCheck) ? $this->readUser($this->insert(SqlTables::users, $user)) : false;
    }
    
    public function readUser(int $userId) {
        return $this
            ->select([SqlTables::users->name])
            ->where(UserFields::id->name,"'$userId'")
            ->exec()[0];
    }

    public function updateUser(UserEntity $user) {
        $values = (array)$user;
        foreach($values as $valKey => $val) {
            if($val !== "") { 
                $values += [substr_replace($valKey,"",0,strpos($valKey,"\x00", 1)+1) => $val];
            }
                unset($values[$valKey]); 
        }
        unset($values['id']);
        empty($values) ? false : $this
        ->update(SqlTables::users->name, $values)
        ->where(UserFields::id->name,$user->getId())
        ->exec();
        
        return $this->readUser($user->getId());
    }
    
    public function deleteUser(int $id) {
        return $this
        ->delete(SqlTables::users->name)
        ->where(UserFields::id->name, $id)
        ->exec();
    }

    public function connectUser(string $email, string $password) {
        
        $user = $this
        ->select([SqlTables::users->name])
        ->where(UserFields::email->name,"'".$email."'")
        ->exec();
        return empty($user) || !password_verify($password, $user[0]->getPassword()) ? false : $user[0];
    }
        
    public function updateUserIsAdmin(int $userId, bool $isAdmin) {
        return $this
        ->update(
            SqlTables::users->name,
            [UserFields::isAdmin->name => (int)$isAdmin])
        ->where(UserFields::id->name, $userId)
        ->exec();
    }
        
    public function readUserList() {
        return $this
        ->select([
            SqlTables::users->name,
        ],[
            SqlTables::users->name . ".*",
        ])
        ->exec(); 
    }

}