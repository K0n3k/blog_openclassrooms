<?php

namespace App\Controllers;
use App\Models\BlogpostListModel;

class BlogpostsController extends Controller {
    protected $entity = "App\Entities\CommentaryEntity";
    
    public function render() {
        $blogpostList = new BlogpostListModel();
        echo $this->twig->render('Posts.twig', [
            "posts" => $blogpostList->getBlogPostListPublished(),
        ]);
    }
}