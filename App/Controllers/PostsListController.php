<?php

namespace App\Controllers;

use App\Enums\Toasts;
use App\Router\Router;
use App\Sessions\Sessions;
use App\Models\PostsModel;

class PostsListController extends Controller
{
    private PostsModel $postlist;
    public function __construct(protected array $parameters)
    {
        parent::__construct($parameters);

        $this->twigFile = 'Admin' . DIRECTORY_SEPARATOR . 'PostsList.twig';

        if (!Sessions::getUser() || !Sessions::getUser()->getIsAdmin()) {
            Router::redirect(301);
        } else {
            $this->postlist = new PostsModel();
            $this->parameters["method"] === "GET" ? $this->getTreatment() : $this->postTreatment();
        }
    }

    private function getTreatment()
    {
        $this->parameters["postlist"] = $this->postlist->readPostList();
        return $this->render($this->twigFile);
    }

    private function postTreatment() : void
    {
        $this->parameters["post"]["action"] = $this->cleanData($this->parameters["post"]["action"]);
        switch ($this->parameters["post"]["action"]) {
            case 'update':
                empty($this->parameters["post"]["isPublished"]) ? $isPublished = true : $isPublished = false;
                $this->postlist->updatePostIsPublished($this->cleanData($this->parameters["post"]["id"]), $isPublished);
                $isPublished ? Sessions::addToast(Toasts::PostPublished) : Sessions::addToast(Toasts::PostUnPublished);
                break;
            case 'delete':
                $this->postlist->deletePost($this->cleanData($this->parameters["post"]["id"]));
                Sessions::addToast(Toasts::PostDeleted);
                break;
            default:
                break;
        }
        Router::redirect(302, $this->parameters["url"]["path"]);
    }
}
