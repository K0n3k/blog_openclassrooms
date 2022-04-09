<?php

namespace App\Controllers;

use App\Models\UserlistModel;

class UserlistController extends Controller {

    public function render() {

        if(array_key_exists("user", $_SESSION) && $_SESSION["user"]->getIsAdmin()) {
            $userList = new UserlistModel();
            echo $this->twig->render('Admins'. DIRECTORY_SEPARATOR . 'UsersList.twig', [
                "users" => $userList->getUserList(),
            ]);
        } else {
            $this->router->redirect("/", 302);
        }
    }

}