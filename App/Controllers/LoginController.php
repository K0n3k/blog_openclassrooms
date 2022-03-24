<?php

namespace App\Controllers;

class LoginController extends Controller {
    public function render() {
        echo $this->twig->render('Login.twig');
    }
}