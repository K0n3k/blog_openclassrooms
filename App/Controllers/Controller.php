<?php

namespace App\Controllers;

use App\MySession\MySession;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Controller {

    protected $twig;
    protected MySession $mySession;

    public function __construct(protected array $server, string $page_title, protected $router){
        //$this->mySession = new MySession();
        $isConnected = false;
        $isAdmin = false;

        $loader = new FilesystemLoader(dirname(__DIR__).DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR);
        $this->twig = new Environment($loader);

        session_start();

        if(!empty($_SESSION)) {
            $isConnected = true;
            $isAdmin = $_SESSION["user"]->getIsAdmin();
        }
        echo $this->twig->render('Layout.twig',["page_title" => $page_title, "isConnected" => $isConnected, "isAdmin" => $isAdmin]);
    }

    public function render() {
    }

    protected function emptyFields() {
        foreach ($this->server["parameters"] as $param) {
            if (empty($param)) {
                return true;
            }
        }
        return false;
    }

    protected function isPostMethod() {
        return array_key_exists("parameters", $this->server) ? true : false;
    }

}