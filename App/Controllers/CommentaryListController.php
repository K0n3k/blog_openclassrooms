<?php

namespace App\Controllers;

use App\Models\CommentaryListModel;

class CommentaryListController extends Controller {

    public function render() {

        if(array_key_exists("user", $_SESSION) && $_SESSION["user"]->getIsAdmin()) {
            $userList = new CommentaryListModel();
            echo $this->twig->render('Admins'. DIRECTORY_SEPARATOR . 'CommentaryList.twig', [
                "commentaries" => $userList->getCommentaryList(),
            ]);
        } else {
            $this->router->redirect("/", 302);
        }
    }

}