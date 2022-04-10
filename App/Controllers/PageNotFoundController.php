<?php

namespace App\Controllers;

class PageNotFoundController extends Controller {
    public function render() {
        echo $this->twig->render("PageNotFound.twig");
    }
}