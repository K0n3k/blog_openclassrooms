<?php

namespace App\MySession;

use App\Entities\UserEntity;

class MySession {
    public function getSESSION() {
        return $_SESSION;
    }

    public function getUser() {
        return isset($_SESSION["user"]) ? $_SESSION["user"] : false;
    }

    public function setUser(UserEntity $user) {
        $_SESSION["user"] = $user;
        return MySession::getUser();
    }

    public function sessionStart() {
        return session_start();
    }

    public function sessionDestroy() {
        unset($_SESSION);
        return session_destroy();
    }
}