<?php

namespace App\Controllers;

class ForbiddenController extends Controller {

    public function __construct(protected array $parameters){
        parent::__construct($parameters);

                $this->twigFile = "Errors". DIRECTORY_SEPARATOR ."Forbidden.twig";
                $this->render($this->twigfile);
                header("Status: 403 Acces refusé", false, 403);
    }
}