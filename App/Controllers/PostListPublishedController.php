<?php

namespace App\Controllers;
use App\Models\PostsModel;

class PostListPublishedController extends Controller {
    
    public function __construct(protected array $parameters) {
        parent::__construct($parameters);
        
        $this->twigFile = 'Public' . DIRECTORY_SEPARATOR . 'PostListPublished.twig';
        $publishedPostList = new PostsModel();
        $this->parameters["postListPublished"] = $publishedPostList->readPostListPublished();
        foreach ($this->parameters["postListPublished"] as $postKey => $postvalue) {
            $this->parameters["postListPublished"][$postKey]->setContent(htmlspecialchars_decode($this->parameters['postListPublished'][$postKey]->getContent()));

        }
        return $this->render($this->twigFile);
    }
}