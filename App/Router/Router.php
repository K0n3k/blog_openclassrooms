<?php

namespace App\Router;

Class Router {

    public function reachRoute(array $server)
    {
        if(array_key_exists("PATH_INFO", $server) && $server["REQUEST_URI"] !== $server["PATH_INFO"]) {
            $params[0] = '404';
        } else {
            $params = array_filter(explode('/', ltrim($server["REQUEST_URI"],"/")), 'strlen');
        }
        if(!array_key_exists(0,$params)) {
            $params[0] = "/" ;
        }

        $controllerRequest = match(strtolower($params[0])) {
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

        $controller = new $controllerRequest['controllerName']($params, $server["REQUEST_METHOD"], $controllerRequest['pageTitle']);
        return $controller->render();
    }

    private function Redirect() {
        header('Status: 301 Moved Permanently', false, 301);
        header('Location: /');
        die();
    }
}