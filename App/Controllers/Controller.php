<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Controller {

    protected $loader;
    protected $twig;    

    public function __construct(
        protected array $params,
        protected string $method, 
        string $page_title){
        
        $this->loader = new FilesystemLoader(dirname(__DIR__).DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR);
        $this->twig = new Environment($this->loader);
        echo $this->twig->render('Layout.twig',["page_title" => $page_title]);
        
    }

    public function render() {
    }

}