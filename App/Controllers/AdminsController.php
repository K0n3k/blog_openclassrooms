<?php

namespace App\Controllers;

class AdminsController extends Controller {

    public function render() {
        echo $this->twig->render('Admins'. DIRECTORY_SEPARATOR . 'Dashboard.twig');
    }

}