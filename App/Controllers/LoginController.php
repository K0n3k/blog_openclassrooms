<?php

namespace App\Controllers;

use App\Models\LoginModel;

class LoginController extends Controller
{

    public function render()
    {
        $errorLogin = false;
        $emptyField = false;

        if ($this->isPostMethod()) {

            if (!$this->emptyFields()) {

                $login = new LoginModel();

                $user = $login->connectUser(
                    $this->server["parameters"]["username"],
                    $this->server["parameters"]["password"]
                );
                if (!$user) {
                    $errorLogin = true;
                } else {
                    if (!isset($_SESSION["user"])) {
                        $_SESSION["user"] = $user;
                    }
                }
            }
        }

        if (isset($_SESSION["user"])) {
            $this->router->redirect("/", "302");
        } else {
            session_unset();
            session_destroy();
            echo $this->twig->render('Login.twig', ["errorLogin" => $errorLogin, "emptyField" => $emptyField]);
        }
        //echo $this->twig->render('Login.twig', ["errorLogin" => $errorLogin]);

    }
}
