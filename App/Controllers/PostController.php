<?php

namespace App\Controllers;

use App\Enums\Toasts;
use App\Models\CommentarysModel;
use App\Models\PostsModel;
use App\Router\Router;
use App\Entitys\CommentaryEntity;
use App\Sessions\Sessions;

class PostController extends Controller {
    private CommentarysModel $commentaryList;

    public function __construct(protected array $parameters) {
        parent::__construct($parameters);

        $this->twigFile = "Public" . DIRECTORY_SEPARATOR . "Post.twig";
        $this->commentaryList = new CommentarysModel();
        $blogpost = new PostsModel();

        $this->parameters["blogpost"] =  $blogpost->readPostPublished($this->parameters["url"]["postId"]);
        $this->parameters["blogpost"]->setContent(htmlspecialchars_decode($this->parameters["blogpost"]->getContent()));
        $this->parameters["commentarylist"] = $this->commentaryList->readCommentaryListValidated($this->parameters["url"]["postId"]);

        $this->parameters["method"] === "GET" ? $this->getTreatment() : $this->postTreatment();
    }

    private function getTreatment(): void {
        if(Sessions::getUser()) {
            $this->parameters["user"]["firstname"] = Sessions::getUser()->getFirstname();
            $this->parameters["user"]["lastname"] = Sessions::getUser()->getLastname();
        }
        if(!$this->parameters["blogpost"]) {
            Router::redirect(404, "NotFound");
        }
        $this->parameters["blogpost"]->setSlug(str_replace(" ", "-",$this->parameters["blogpost"]->getSlug()));
        
        if($this->parameters["blogpost"]->getSlug() === $this->parameters["url"]["slug"]) {
            $this->render($this->twigFile);
        } else {
            Router::redirect(301, $this->parameters["url"]["path"]."/".$this->parameters["blogpost"]->getId()."/".$this->parameters["blogpost"]->getSlug());            
        }
        return;
    }

    private function postTreatment(): void {
        $commentary = new CommentaryEntity();
        $commentary
            ->setIdBlogpost($this->parameters["blogpost"]->getId())
            ->setIsValidated((int)false)
            ->setCommentary($this->cleanData($this->parameters['post']['commentary']));
        if(empty($commentary->getCommentary())) {
            Sessions::addToast(Toasts::AllFieldsMustBeFilled);
            Router::redirect(302, implode("/",$this->parameters["url"]));
        }

        if(Sessions::getUser()) {
            $commentary
                ->setFirstname(Sessions::getUser()->getFirstname())
                ->setLastname(Sessions::getUser()->getLastname());
        } else {
            if(empty($this->parameters["post"]["firstname"]) || empty($this->parameters["post"]["lastname"])) {
                    Sessions::addToast(Toasts::AllFieldsMustBeFilled);
                    Router::redirect(302, implode("/",$this->parameters["url"]));
    
            }
            $commentary
                ->setFirstname($this->cleanData($this->parameters["post"]["firstname"]))
                ->setLastname($this->cleanData($this->parameters["post"]["lastname"]));
        }
        
        

        $this->commentaryList->createCommentary($commentary);
        Sessions::addToast(Toasts::CommentaryCreated);
        Router::redirect(302, implode("/",$this->parameters["url"]));

        return;
    }
}