<?php

namespace App\Controllers;

use App\Entitys\UserEntity;
use App\Models\UsersModel;
use App\Router\Router;
use App\Sessions\Sessions;
use App\Enums\UserFields;
use App\Enums\Toasts;

class ProfileController extends Controller {

    private UsersModel $user;

    public function __construct(protected array $parameters)
    {
        parent::__construct($parameters);

        $this->twigFile = 'Public' . DIRECTORY_SEPARATOR . 'Profile.twig';

        if (!Sessions::getUser()) {
            Router::redirect(301);
        } else {
            $this->user = new UsersModel();
            $this->parameters["method"] === "GET" ? $this->getTreatment() : $this->postTreatment();
        }
    }

    private function getTreatment()
    {
        $this->parameters["user"] = $this->user->readUser(Sessions::getUser()->getId());
        return $this->render($this->twigFile);
    }

    private function postTreatment()
    { 
        switch ($this->parameters["post"]["action"]) {
            case 'updateIsAdmin':
                empty($this->parameters["post"]["isAdmin"]) ? $isAdmin = true : $isAdmin = false;
                $this->userlist->updateUserIsAdmin($this->parameters["post"]["id"], $isAdmin);
                $isAdmin ? Sessions::addToast(Toasts::UserIsAdmin) : Sessions::addToast(Toasts::UserIsNotAdmin);
                break;

            case 'updateUser':
                //dd($this->parameters);
                if (
                    empty($this->parameters["post"][UserFields::email->name]) &&
                    empty($this->parameters["post"][UserFields::password->name]) &&
                    empty($this->parameters["post"][UserFields::firstname->name]) &&
                    empty($this->parameters["post"][UserFields::lastname->name])
                ) {
                    Sessions::addToast(Toasts::UserFieldsEmpty);
                } else { 
                    $user = new UserEntity();
                    $user->setId(Sessions::getUser()->getId());
                    $user->setEmail($this->cleanData($this->parameters["post"][UserFields::email->name]));
                    $user->setPassword(password_hash($this->cleanData($this->parameters["post"][UserFields::password->name]), null));
                    $user->setFirstname($this->cleanData($this->parameters["post"][UserFields::firstname->name]));
                    $user->setLastname($this->cleanData($this->parameters["post"][UserFields::lastname->name]));
                    $user = $this->user->updateUser($user);
                    Sessions::getUser($user);
                    Sessions::addToast(Toasts::UserModified);
                }
                break;
            case 'delete':
                $this->user->deleteUser($this->parameters["post"]["id"]);
                Sessions::addToast(Toasts::UserDeleted);
                break;
            default:
                break;
        }
        Router::redirect(302, $this->parameters["url"]["path"]);
    }
}
