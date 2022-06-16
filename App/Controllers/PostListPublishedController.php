<?php

namespace App\Controllers;
use App\Models\PostsModel;

class PostListPublishedController extends Controller {
    
    public function __construct(protected array $parameters) {
        parent::__construct($parameters);
        
        $this->twigFile = 'Public' . DIRECTORY_SEPARATOR . 'PostListPublished.twig';
        $publishedPostList = new PostsModel();
        $this->parameters["postListPublished"] = $publishedPostList->readPostListPublished();
        return $this->render($this->twigFile);
    }
}