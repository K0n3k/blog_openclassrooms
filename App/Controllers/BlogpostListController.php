<?php

namespace App\Controllers;

use App\Models\BlogpostListModel;

class BlogpostListController extends Controller {

    public function render() {
        $blogpostList = new BlogpostListModel();
        echo $this->twig->render('Admins'. DIRECTORY_SEPARATOR . 'BlogpostList.twig', [
            "posts" => $blogpostList->getBlogPostList(),
        ]);
    }

}