<?php

namespace App\Controllers;

use App\Sessions\Sessions;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Controller {
    
    protected Environment $twig;
    protected string $twigFile;

    public function __construct(protected array $parameters)
    {
        $loader = new FilesystemLoader('..'.DIRECTORY_SEPARATOR.'App'.DIRECTORY_SEPARATOR.'Views');
        $this->twig = new Environment($loader);

        Sessions::session_start();
        if($this->parameters["method"] === "GET") {
            $toasts = Sessions::getToast();
            //dump($toasts);
            if($toasts) {
                $this->parameters["toasts"] = $toasts;
            }
            //dump($this->parameters);
            }
            //echo $toasts;
        $user = Sessions::getUser();
        !$user ? $this->twig->addGlobal("user", null) : $this->twig->addGlobal("user", $user);
    }

    protected function render(string $twigFile, array $variables = null) {
        $parameters = $this->parameters;
        //dd($variables);
        if($variables !== null) {
                $parameters += $variables;
        }
            
        echo $this->twig->render($twigFile, $parameters);
    }

    protected function cleanData(string $data) : string {
        return htmlentities($data);
    }
}