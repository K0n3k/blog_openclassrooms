<?php

namespace App\Controllers;

use App\Models\CommentaryListModel;

class CommentaryListController extends Controller {

    public function render() {
        $userList = new CommentaryListModel();
        echo $this->twig->render('Admins'. DIRECTORY_SEPARATOR . 'CommentaryList.twig', [
            "commentaries" => $userList->getCommentaryList(),
        ]);
    }

}