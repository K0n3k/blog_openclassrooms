<?php

namespace App\Controllers;

use App\Entities\UserEntity;

Class ProfileController extends Controller {

    public function render()
    {
        if(!empty($_SESSION)) {
            echo $this->twig->render("Profile.twig", ["user" => $_SESSION["user"]]);
            
        } else {
            $this->router->redirect("/", 302);
        }
    }
}