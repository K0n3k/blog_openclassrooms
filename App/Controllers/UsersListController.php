<?php

namespace App\Controllers;

use App\Enums\Toasts;
use App\Enums\UserFields;
use App\Sessions\Sessions;
use App\Router\Router;
use App\Models\UsersModel;

class UsersListController extends Controller {

    private UsersModel $userlist;

    public function __construct(protected array $parameters) {
        parent::__construct($parameters);

        $this->twigFile = 'Admin' . DIRECTORY_SEPARATOR . 'UsersList.twig';
        
        if(!Sessions::getUser() || !Sessions::getUser()->getIsAdmin()) {
            Router::redirect(403, "forbidden");
        } else {
            $this->userlist = new UsersModel();
            $this->parameters["method"] === "GET" ? $this->getTreatment() : $this->postTreatment() ;
        }
    }
    
    private function getTreatment() {
        $this->parameters["userlist"] = $this->userlist->readUserList();
        return $this->render($this->twigFile);
    }

    private function postTreatment() {
        $this->parameters["post"]["action"] = $this->cleanData($this->parameters["post"]["action"]);
        switch($this->parameters["post"]["action"]) {
            case 'updateIsAdmin':
                empty($this->parameters["post"]["isAdmin"]) ? $isAdmin = true : $isAdmin = false;
                $this->userlist->updateUserIsAdmin($this->parameters["post"]["id"], $isAdmin);
                $isAdmin? Sessions::addToast(Toasts::UserIsAdmin) : Sessions::addToast(Toasts::UserIsNotAdmin) ;
                break;

            case 'updateUser':
                //dd($this->parameters);
                $this->userlist->updateUser(
                    $this->parameters["post"]["id"],
                    [
                        UserFields::email->name => $this->cleanData($this->parameters["post"]["email"]),
                        UserFields::password->name => $this->cleanData($this->parameters["post"]["password"]),
                        UserFields::firstname->name => $this->cleanData($this->parameters["post"]["firstname"]),
                        UserFields::lastname->name => $this->cleanData($this->parameters["post"]["lastname"]),
                    ]);
                Sessions::addToast(Toasts::UserModified);
                break;

            case 'delete':
                $this->userlist->deleteUser($this->cleanData($this->parameters["post"]["id"]));
                Sessions::addToast(Toasts::UserDeleted);
                break;

            default:
                break;
                
        }
        Router::redirect(302, $this->parameters["url"]["path"]);
    }

}