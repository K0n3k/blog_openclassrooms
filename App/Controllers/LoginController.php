<?php

namespace App\Controllers;
use App\Models\LoginModel;

class LoginController extends Controller {
    public function render() {
        $errorLogin = false;
        session_start();
        if (array_key_exists("parameters", $this->server)) {
            $login = new LoginModel();
            $user = $login->connectUser(
                $this->server["parameters"]["username"],
                $this->server["parameters"]["password"]);
                if(empty($user)) {
                    $errorLogin = true;
                } else {
                if(!isset($_SESSION["user"])) {                    
                    $_SESSION["user"] = $user;
                    
                }
            }
        }
        
        if(isset($_SESSION["user"])) {
            dd($_SESSION);
        } else {
            $_SESSION = array();
            session_destroy();
            echo $this->twig->render('Login.twig', ["errorLogin" => $errorLogin]);    
        }
        //echo $this->twig->render('Login.twig', ["errorLogin" => $errorLogin]);
        
    }
}