<?php

namespace App\Controllers;

use App\Entities\UserEntity;
use App\Models\CommentaryListModel;

class CommentaryListController extends Controller {

    public function render() {
        session_start();
        $user = $_SESSION["user"][0];
        

        if($user->getIsAdmin()) {
            $userList = new CommentaryListModel();
            echo $this->twig->render('Admins'. DIRECTORY_SEPARATOR . 'CommentaryList.twig', [
                "commentaries" => $userList->getCommentaryList(),
            ]);
        } else {
            $this->router->redirect("/", "302");
        }
    }

}