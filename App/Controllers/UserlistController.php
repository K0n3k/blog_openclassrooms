<?php

namespace App\Controllers;

use App\Models\UserlistModel;

class UserlistController extends Controller {

    public function render() {
        $userList = new UserlistModel();
        echo $this->twig->render('Admins'. DIRECTORY_SEPARATOR . 'UsersList.twig', [
            "users" => $userList->getUserList(),
        ]);
    }

}