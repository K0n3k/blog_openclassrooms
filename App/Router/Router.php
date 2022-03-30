<?php

namespace App\Router;

Class Router {
    
    private array $server;

    public function __construct(array $server)
    {
        $this->server["method"] = $server["REQUEST_METHOD"];
        if(array_key_exists("PATH_INFO", $server) && $server["REQUEST_URI"] !== $server["PATH_INFO"]) {
            $this->server["url"] = ["404"];
        } else {
            $this->server["url"] = array_filter(explode('/', ltrim($server["REQUEST_URI"],"/")), 'strlen');
        }
        if(!array_key_exists(0,$this->server["url"])) {
            // aucun paramètre dans l'url
            $this->server["url"] = ["/"] ;
        }
        if($server["REQUEST_METHOD"] === "POST") {

        }
    }

    public function setParams($params) {

    }

    public function reachRoute()
    {

        $controllerRequest = match(strtolower($this->server["url"][0])) {
            'login' => [
                'controllerName' => 'App\Controllers\LoginController',
                'pageTitle' => 'Login',
            ],
            'registration' => [
                'controllerName' => 'App\Controllers\RegistrationsController',
                'pageTitle' => 'Registration',
            ],
            'admin' => [
                'controllerName' => 'App\Controllers\AdminsController',
                'pageTitle' => 'Administration',
            ],
            'userlist' => [
                'controllerName' => 'App\Controllers\UserlistController',
                'pageTitle' => 'User list',
            ],
            'blopostlist' => [
                'controllerName' => 'App\Controllers\BlogpostListController',
                'pageTitle' => 'Blogpost list',
            ],
            'commentarylist' => [
                'controllerName' => 'App\Controllers\CommentaryListController',
                'pageTitle' => 'Commentary list',
            ],
            '404' => [
                'controllerName' => 'App\Controllers\BlogpostsController',
                'pageTitle' => 'Error 404',
            ],
            default => [
                'controllerName' => 'App\Controllers\BlogpostsController',
                'pageTitle' => 'Blog',
            ],
        };

        $controller = new $controllerRequest['controllerName']($this->server, $controllerRequest['pageTitle']);
        return $controller->render();
    }

    private function Redirect() {
        header('Status: 301 Moved Permanently', false, 301);
        header('Location: /');
        die();
    }
}