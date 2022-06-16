<?php

namespace App\Controllers;

use App\Enums\Toasts;
use App\Router\Router;
use App\Sessions\Sessions;

Class LogoutController extends Controller {

    public function __construct()
    {
        Sessions::session_start();
        $user = Sessions::getUser();
        if(!empty($user)) {
            Sessions::session_destroy();
            Sessions::session_start();
            //dump($user);
        }
        Sessions::addToast(Toasts::UserDisconnected);
        Router::redirect(302);
    }
}