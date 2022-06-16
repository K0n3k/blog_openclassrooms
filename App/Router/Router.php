<?php

namespace App\Router;

class Router {

    public function __construct(array $server, array $post)
    {
        $parameters["method"] = $server["REQUEST_METHOD"] ;
        !empty($post) ? $parameters["post"] = $post : false;
        
        $url = array_filter(explode('/', ltrim($server["REQUEST_URI"],"/")), 'strlen');

        if($server["REQUEST_URI"] !== "/") {
            // redirections dans le cas où les urls sont manipulées
            $server["PHP_SELF"] !== $server["SCRIPT_NAME"].$server["REQUEST_URI"] ? Router::redirect(404) : false;     
            isset($server["PATH_INFO"]) && $server["PATH_INFO"] !== $server["REQUEST_URI"] ? Router::redirect(404) : false;
        }

        isset($url[0]) ? $parameters["url"]["path"] = $url[0] : $parameters["url"]["path"] = "/";
        isset($url[1]) ? $parameters["url"]["postId"] = $url[1] : false;
        isset($url[2]) ? $parameters["url"]["slug"] = $url[2] : false;
        
        $controllerRequest = $this->matchPath($parameters["url"]["path"]);
        
        isset($controllerRequest["pageTitle"]) ? $parameters["pageTitle"] = $controllerRequest["pageTitle"] : false;
        $controller = new $controllerRequest["controllerName"]($parameters);
        return $controller;
    }
    
    private function matchPath($path) {
        return match(strtolower($path)) {
            'blog' => [
                'controllerName' => 'App\Controllers\PostController',
                'pageTitle' => 'Blog',
            ],
            'contact' => [
                'controllerName' => 'App\Controllers\ContactController',
                'pageTitle' => 'Contactez nous',
            ],
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
                'controllerName' => 'App\Controllers\RegistrationController',
                'pageTitle' => 'Registration',
            ],
            'userlist' => [
                'controllerName' => 'App\Controllers\UsersListController',
                'pageTitle' => 'User list',
            ],
            'postlist' => [
                'controllerName' => 'App\Controllers\PostsListController',
                'pageTitle' => 'Blogpost list',
            ],
            'commentarylist' => [
                'controllerName' => 'App\Controllers\CommentarysListController',
                'pageTitle' => 'Commentary list',
            ],
            '/' => [
                'controllerName' => 'App\Controllers\PostListPublishedController',
                'pageTitle' => 'Blog',
            ],
            'forbidden' => [
                'controllerName' => 'App\Controllers\ForbiddenController',
                'pageTitle' => 'Error 403',
            ],
            'posteditor' => [
                'controllerName' => 'App\Controllers\PostEditorController',
                'pageTitle' => 'Post editor',
            ],
            default => [
                'controllerName' => 'App\Controllers\NotFoundController',
                'pageTitle' => 'Error 404',
            ],
        };
    }

    public static function redirect(int $code, string $location = null) 
    {
        $matchedCode = match($code) {
            301 => "Redirection permanente",
            302 => "Redirection temporaire",
            401 => "Utilisateur non authentifie",
            403 => "Acces refuse",
            404 => "Page introuvable",
        };

        header("Status: $code $matchedCode", false, $code);
        header("Location: /$location");
        exit();
    }
    
}