<?php

namespace App\Controllers;

use App\Models\BlogpostListModel;

class BlogpostListController extends Controller {

    public function render() {
        if(array_key_exists("user", $_SESSION) && $_SESSION["user"]->getIsAdmin()) {
            $blogpostList = new BlogpostListModel();
            echo $this->twig->render('Admins'. DIRECTORY_SEPARATOR . 'BlogpostList.twig', [
                "posts" => $blogpostList->getBlogPostList(),
            ]);
        } else {
            $this->router->redirect("/", 302);
        }
    }

}