<?php

namespace App\Controllers;
use App\Models\LoginModel;

class LoginController extends Controller {
    public function render() {
        if (!array_key_exists("parameters", $this->server)) {
            echo $this->twig->render('Login.twig');
        } else {
            $login = new LoginModel();
            dd($login);
        }
        
    }
}