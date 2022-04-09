<?php

namespace App\Router;

Class Router {
    
    private array $server;

    public function __construct(array $server)
    {
        if(array_key_exists("PATH_INFO", $server) && $server["REQUEST_URI"] !== $server["PATH_INFO"]) {
            $this->server["url"] = ["404"];
        } else {
            $this->server["url"] = array_filter(explode('/', ltrim($server["REQUEST_URI"],"/")), 'strlen');
        }
        if(!array_key_exists(0,$this->server["url"])) {
            // aucun paramètre dans l'url
            $this->server["url"] = ["/"] ;
        }
        if(array_key_exists("PARAMETERS", $server)) {
            $this->server["parameters"] = $server["PARAMETERS"];
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
            'logout' => [
                'controllerName' => 'App\Controllers\LogoutController',
                'pageTitle' => 'Logout',
            ],
            'profile' => [
                'controllerName' => 'App\Controllers\ProfileController',
                'pageTitle' => 'Profile',
            ],
            'registration' => [
                'controllerName' => 'App\Controllers\RegistrationsController',
                'pageTitle' => 'Registration',
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

        $controller = new $controllerRequest['controllerName']($this->server, $controllerRequest['pageTitle'], $this);
        return $controller->render();
    }

    public function redirect(string $location, int $code) {
        $codeMatched = match($code) {
            301 => "301 moved permanently",
            302 => "302 moved temporarly",
            403 => "403 Forbidden",
            404 => "404 Not found"
        };
        header("Status: $codeMatched", false, $code);
        header("Location: $location");
        die();
    }
}