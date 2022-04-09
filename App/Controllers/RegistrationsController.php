<?php

namespace App\Controllers;

use App\Models\LoginModel;

class RegistrationsController extends Controller {

    public function render() {
        $errorLogin = false;
        $emptyField = false;
        if (array_key_exists("parameters", $this->server)) {
            $login = new LoginModel();
            foreach($this->server["parameters"] as $param) {
                if(empty($param)) {
                    $emptyField = true;
                }
            }
            if(!$emptyField) {
                $password = $this->server["parameters"]["password"];
                $this->server["parameters"]["password"] = password_hash($password, null);
                if ($login->createUser($this->server["parameters"])) {
                    $_SESSION["user"] = $login->connectUser($this->server["parameters"]["email"], $password);
                    $this->router->redirect("/", 302);
                } else {
                    $errorLogin = true;
                }                
            }
        }

        //echo $this->twig->render('Login.twig', ["errorLogin" => $errorLogin]);

        if(empty($_SESSION)) {
            echo $this->twig->render('Registration.twig', ["errorLogin" => $errorLogin, "emptyField" => $emptyField]);
        } else {
            $this->router->redirect("/", 302);
        }

    }
    
}