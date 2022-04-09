<?php

namespace App\Controllers;

Class LogoutController extends Controller {

    public function render()
    {
        if(!empty($_SESSION)) {
            $_SESSION = [];
            session_destroy();
        } 
        $this->router->redirect("/", 302);
    }
}