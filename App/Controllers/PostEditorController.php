<?php

namespace App\Controllers;

use App\Entitys\PostEntity;
use App\Enums\PostFields;
use App\Models\PostsModel;
use App\Models\CommentarysModel;
use App\Sessions\Sessions;
use App\Router\Router;
use App\Enums\Toasts;

class PostEditorController extends Controller {

    private PostsModel $blogpost;
    private CommentarysModel $commentaryList;

    public function __construct(protected array $parameters) {
        parent::__construct($parameters);

        $this->twigFile = 'Admin' . DIRECTORY_SEPARATOR . 'PostEditor.twig';
        
        if(!Sessions::getUser() || !Sessions::getUser()->getIsAdmin()) {
            Router::redirect(301);
        } else {
            $this->blogpost = new PostsModel();
            $this->commentaryList = new CommentarysModel();

            $this->parameters["method"] === "GET" ? $this->getTreatment() : $this->postTreatment() ;
        }
    }

    private function getTreatment() {
        if(isset($this->parameters["url"]["postId"])) {
            $this->parameters["blogpost"] = $this->blogpost->readPost($this->parameters["url"]["postId"]);
            $this->parameters["blogpost"]->setContent(htmlspecialchars_decode($this->parameters['blogpost']->getContent()));
            if($this->parameters["url"]["slug"] !== str_replace(" ", "-",$this->parameters["blogpost"]->getSlug())) {
                Router::redirect(301, $this->parameters["url"]["path"]."/".$this->parameters["blogpost"]->getId()."/".str_replace(" ", "-",$this->parameters["blogpost"]->getSlug()));
            }
            $this->parameters["commentaries"] = $this->commentaryList->readPostCommentaryList($this->parameters["url"]["postId"]);
        }
        $this->render($this->twigFile);
    }

    private function postTreatment() {
        switch($this->parameters["post"]["action"]) {
            case "updatePost":

                if (
                    empty($this->parameters["post"][PostFields::title->name]) &&
                    empty($this->parameters["post"][PostFields::chapo->name]) &&
                    empty($this->parameters["post"][PostFields::content->name])
                ) {
                    Sessions::addToast(Toasts::PostFieldsEmpty);
                } else { 
                    $post = new PostEntity();
                    $post->setId($this->parameters["url"]["postId"]);
                    $post->setTitle($this->parameters["post"]["title"]);
                    //$post->setSlug($this->cleanData(str_replace(" ", "-", $post->getTitle())));
                    if (isset($this->parameters["post"]["isPublished"])) {
                        $post->setIsPublished((int)true);
                        Sessions::addToast(Toasts::PostPublished);
                    } else {
                        $post->setIsPublished((int)false);
                    }
                    $post->setChapo($this->cleanData($this->parameters['post']['chapo']));
                    $post->setContent($this->cleanData($this->parameters['post']['content']));

                    $this->parameters["blogpost"] = $this->blogpost->updatePost($post);
                    Sessions::addToast(Toasts::PostModified);
                }
                break;
                case "createPost":
                    unset($this->parameters["post"]["action"]);
                    unset($this->parameters["post"]["files"]);
                    $post = new PostEntity();
                    $post->setIdAuthor(Sessions::getUser()->getId());
                    
                    foreach($this->parameters["post"] as $postValue) {
                        if(empty($postValue))  {
                            Sessions::addToast(Toasts::AllFieldsMustBeFilled);
                            //dump($this->parameters, $postValue);
                            Router::redirect(301, $this->parameters["url"]["path"]);
                        }
                    }
                $post->setTitle($this->cleanData($this->parameters['post']['title']));
                //$post->setSlug($this->cleanData(str_replace(" ", "-", $post->getTitle())));
                
                if (isset($this->parameters["post"]["isPublished"])) {
                    $post->setIsPublished((int)true);
                    Sessions::addToast(Toasts::PostPublished);
                } else {
                    $post->setIsPublished((int)false);
                }
                $post->setChapo($this->cleanData($this->parameters['post']['chapo']));
                $post->setContent($this->cleanData($this->parameters['post']['content']));
                
                $createdBlogpost = $this->blogpost->readPost($this->blogpost->createPost($post));
                Sessions::addToast(Toasts::PostCreated);
                $RedirectedUrl = $this->parameters["url"]["path"]."/".$createdBlogpost->getId()."/".str_replace(" ", "-", $createdBlogpost->getSlug());
                Router::redirect(301, $RedirectedUrl);
                break;
            case "deleteCommentary":
                $this->commentaryList->deleteCommentary($this->parameters["post"]["id"]);
                Sessions::addToast(Toasts::CommentaryDeleted);
                break;
            case "updateIsValidated":
                empty($this->parameters["post"]["isValidated"]) ? $isValidated = true : $isValidated = false;
                $this->commentaryList->updateCommentaryIsValidated($this->parameters["post"]["id"], $isValidated);
                $isValidated ? Sessions::addToast(Toasts::CommentaryValidated) : Sessions::addToast(Toasts::CommentaryUnValidated);
                break;
            default:
                break;
        }
        Router::redirect(302, implode("/",$this->parameters["url"]));
    }

}