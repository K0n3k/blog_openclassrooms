<?php

namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Controller {

    protected $loader;
    protected $twig; 

    public function __construct(
        protected array $server,
        string $page_title,
        protected $router){
        
            $isConnected = false;
            $isAdmin = false;

        $this->loader = new FilesystemLoader(dirname(__DIR__).DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR);
        $this->twig = new Environment($this->loader);
        session_start();
        if(!empty($_SESSION)) {
            $isConnected = true;
            $isAdmin = $_SESSION["user"]->getIsAdmin();
        }
        echo $this->twig->render('Layout.twig',["page_title" => $page_title, "isConnected" => $isConnected, "isAdmin" => $isAdmin]);
    }

    public function render() {
    }

}