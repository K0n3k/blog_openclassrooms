<?php

namespace App\Controllers;

class NotFoundController extends Controller {

    public function __construct(protected array $parameters){
        parent::__construct($parameters);

                $this->twigFile = "Errors". DIRECTORY_SEPARATOR ."NotFound.twig";
                $this->render($this->twigfile);
                header("Status: 404 Page introuvable", false, 404);
    }
}