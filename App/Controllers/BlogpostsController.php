<?php

namespace App\Controllers;

final class BlogpostsController extends Controller {

    public function render() {
        echo $this->twig->render('Posts.twig');
    }
}