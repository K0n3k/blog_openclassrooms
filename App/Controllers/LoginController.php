<?php

namespace App\Controllers;

class LoginController extends Controller {
    public function render() {
        if ($this->server["method"] === "GET") {
            echo $this->twig->render('Login.twig');
        }
        if ($this->server["method"] === "POST") {
            echo $this->twig->render('Login.twig');
        }
        
    }
}