<?php

namespace App\Sessions;
use App\Entitys\UserEntity;
use App\Enums\Toasts;

class Sessions {
    
    public static function setUser(UserEntity $user = null) {
        if (is_null($user)) {
            $_SESSION["user"] = new UserEntity();
            $_SESSION["user"]->setIsAdmin(false);
        } else {
            $_SESSION["user"] = $user;
        }
        return Sessions::getUser();
    }
    
    public static function getUser() {
        return isset($_SESSION["user"]) ? $_SESSION["user"] : false;
    }
    
    public static function addToast(Toasts $toast) {
        if(!isset($_SESSION["toasts"])) {
            $_SESSION["toasts"] = [];
        }
        $_SESSION["toasts"][$toast->name.count($_SESSION["toasts"])] = $toast->name ;
        //dump($_SESSION);
        return $_SESSION["toasts"];
    }

    public static function getToast() {
        $return = false;
        if(!empty($_SESSION["toasts"])) {
            $return = $_SESSION["toasts"];
            unset($_SESSION["toasts"]);
        }
        return $return;
    }
    
    
    public static function session_id() {
        return session_id();
    }

    public static function session_start() {
        return session_start();
    }

    public static function session_destroy() {
        unset($_SESSION);
        return session_destroy();
    }
}