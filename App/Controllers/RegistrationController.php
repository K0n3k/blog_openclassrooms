<?php

namespace App\Controllers;

use App\Entitys\UserEntity;
use App\Enums\Toasts;
use App\Enums\UserFields;
use App\Models\UsersModel;
use App\Sessions\Sessions;
use App\Router\Router;

class RegistrationController extends Controller {

    public function __construct(protected array $parameters) {
        parent::__construct($parameters);
        
        $this->twigFile = 'Public' . DIRECTORY_SEPARATOR . 'Registration.twig';
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

    private function postTreatment() {
        
        if(empty($this->parameters["post"][UserFields::email->name]) || 
        empty($this->parameters["post"][UserFields::firstname->name]) ||
        empty($this->parameters["post"][UserFields::lastname->name]) ||
        empty($this->parameters["post"][UserFields::password->name])
        ) {
            Sessions::addToast(Toasts::AllFieldsMustBeFilled);
            Router::redirect(301, "/registration");
        } else {
            $usersModel = new UsersModel();
            $user = new UserEntity();
            $user
            ->setEmail($this->cleanData($this->parameters["post"][UserFields::email->name]))
            ->setPassword(password_hash($this->cleanData($this->parameters["post"][UserFields::password->name]), null))
            ->setFirstname($this->cleanData($this->parameters["post"][UserFields::firstname->name]))
            ->setLastname( $this->cleanData($this->parameters["post"][UserFields::lastname->name]))
            ->setIsAdmin((int)false);
            
            $user = $usersModel-> createUser($user);

            if(!$user) {
                Sessions::addToast(Toasts::EmailAllreadyUsed);
                Router::redirect(301, $this->parameters["url"]["path"]);
            } else {
                $user = $usersModel->connectUser($this->cleanData($this->parameters["post"][UserFields::email->name]), $this->cleanData($this->parameters["post"][UserFields::password->name]));
                Sessions::setUser($user);
                Sessions::addToast(Toasts::UserCreated);
                Sessions::addToast(Toasts::UserConnected);
                Router::redirect(302);
            }
        }
    }
}