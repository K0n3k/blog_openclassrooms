<?php

namespace App\Controllers;

use App\Enums\UserFields;
use App\Enums\Toasts;
use App\Router\Router;
use App\Models\UsersModel;
use App\Sessions\Sessions;

class LoginController extends Controller {

    private UsersModel $usersModel;

    public function __construct(protected array $parameters) {
        parent::__construct($parameters);
        
        $this->twigFile = 'Public' . DIRECTORY_SEPARATOR . 'Login.twig';
        $this->parameters["method"] === "GET" ? $this->getTreatment() : $this->postTreatment() ;
        //dd($this->parameters);
    }

    private function getTreatment() {
        if(!Sessions::getUser()) {
            return $this->render($this->twigFile);
        } else {
            Router::redirect(302) ;
        }
    }
    
    private function postTreatment() : void {
        if(empty($this->parameters["post"][UserFields::email->name]) || empty($this->parameters["post"][UserFields::password->name])) {
            Sessions::addToast(Toasts::AllFieldsMustBeFilled);
            Router::redirect(302, $this->parameters["url"]["path"]);
        } else {
            $this->usersModel = new UsersModel();
            $user = $this->usersModel->connectUser($this->parameters["post"][UserFields::email->name], $this->parameters["post"][UserFields::password->name]);
            if(!$user) {
                Sessions::addToast(Toasts::IncorrectEmailOrPassword);
                Router::redirect(302, $this->parameters["url"]["path"]);
            } else {
                Sessions::setUser($user);
                Sessions::addToast(Toasts::UserConnected);
                Router::redirect(302);
            }
        }
    }
}