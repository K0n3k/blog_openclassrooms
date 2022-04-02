<?php

namespace App\Controllers;
use App\Models\LoginModel;

class LoginController extends Controller {
    public function render() {
        $errorLogin = false;
        if (array_key_exists("parameters", $this->server)) {
            $login = new LoginModel();
            $connect = $login->connectUser($this->server["parameters"]["username"], $this->server["parameters"]["password"]);
            if(empty($connect)) {
                $errorLogin = true;
            } else {
                
            }
        }
        echo $this->twig->render('Login.twig', ["errorLogin" => $errorLogin]);
        dd($connect,$errorLogin);
        
    }
}