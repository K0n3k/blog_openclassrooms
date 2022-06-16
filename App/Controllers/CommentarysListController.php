<?php

namespace App\Controllers;

use App\Enums\Toasts;
use App\Sessions\Sessions;
use App\Router\Router;
use App\Models\CommentarysModel;

class CommentarysListController extends Controller
{

    private CommentarysModel $commentaryList;

    public function __construct(protected array $parameters)
    {
        parent::__construct($parameters);

        $this->twigFile = 'Admin' . DIRECTORY_SEPARATOR . 'CommentarysList.twig';

        if (!Sessions::getUser() || !Sessions::getUser()->getIsAdmin()) {
            Router::redirect(301);
        } else {
            $this->commentaryList = new CommentarysModel();
            $this->parameters["method"] === "GET" ? $this->getTreatment() : $this->postTreatment();
        }
    }
    
    private function getTreatment()
    {
        $this->parameters["commentarylist"] = $this->commentaryList->readCommentaryList();
        //dd($this);
        return $this->render($this->twigFile);
    }

    private function postTreatment()
    {
        switch ($this->parameters["post"]["action"]) {
            case 'update':
                empty($this->parameters["post"]["isValidated"]) ? $isValidated = true : $isValidated = false;
                $this->commentaryList->updateCommentaryIsValidated($this->parameters["post"]["id"], $isValidated);
                $isValidated ? Sessions::addToast(Toasts::CommentaryValidated) : Sessions::addToast(Toasts::CommentaryUnValidated);
                break;
            case 'delete':
                $this->commentaryList->deleteCommentary($this->parameters["post"]["id"]);
                Sessions::addToast(Toasts::CommentaryDeleted);
                break;
            default:
                break;
        }
        Router::redirect(302, $this->parameters["url"]["path"]);
    }
}
