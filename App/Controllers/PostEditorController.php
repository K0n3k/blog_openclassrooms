<?php

namespace App\Controllers;
use App\Models\BlogpostListModel;
use App\Models\CommentaryListModel;

class PostEditorController extends Controller {
    public function render() {
        if(array_key_exists("user", $_SESSION) && $_SESSION["user"]->getIsAdmin()) {
            $emptyField = false;
            $blogpostList = new BlogpostListModel();
            $commentaryList = new CommentaryListModel();
            if (array_key_exists("parameters", $this->server)) {
                switch($this->server["parameters"]["action"]) {
                    case "updatePost" :
                        unset($this->server["parameters"]["action"]);
                        unset($this->server["parameters"]["files"]);
                        foreach ($this->server["parameters"] as $paramkey => $param) {
                            if (empty($param)) {
                                unset($this->server["parameters"][$paramkey]);
                            }
                        }
                        $id = 
                        $blogpostList->updatePost($this->server["parameters"]);
                        $this->router->redirect("/posteditor/" . $this->server["url"][1] . "/" . $this->server["url"][2], "302");
                        break;
                    case "createPost" :
                        unset($this->server["parameters"]["action"]);
                        unset($this->server["parameters"]["files"]);
                        
                        foreach ($this->server["parameters"] as $param) {
                            if (empty($param)) {
                                $emptyField = true;
                            }
                        }
                        if(!$emptyField) {
                        $this->server["parameters"]["slug"] = str_replace(" ", "-", $this->server["parameters"]["title"]);
                        if(key_exists("isPublished", $this->server["parameters"])) {
                            $this->server["parameters"]["isPublished"] = true;
                        }
                        //dd($this->server);
                            $post = $blogpostList->createPost($this->server["parameters"]);
                            $this->router->redirect("/posteditor/" . $post->getId() . "/" . str_replace(" ", "-",$post->getSlug()), "302");
                        } 
                            break;
                    case "deleteCommentary" :
                        $commentaryList->deleteCommentary($this->server["parameters"]["id"]);
                        $this->router->redirect("/posteditor/" . $this->server["url"][1] . "/" . $this->server["url"][2], "302");
                        break;
                    case "updateIsValidated" :
                        $isValidated = !$this->server["parameters"]["isValidated"];
                        $commentaryList->changeisValidatedCommentary($this->server["parameters"]["id"], $isValidated);
                        $this->router->redirect("/posteditor/" . $this->server["url"][1] . "/" . $this->server["url"][2], "302");
                        break;
                    default:
                    $this->router->redirect("/posteditor/" . $this->server["url"][1] . "/" . $this->server["url"][2], "302");
                        break;
                }
            }

            if (array_key_exists("url", $this->server) && count($this->server["url"]) > 1) {
                $post = $blogpostList->getPost($this->server["url"][1]);
                if(empty($post)) {
                    $this->router->redirect("/404", 404);
                }
            
                if(
                    (count($this->server["url"]) <= 2) ||
                    (isset($this->server["url"][2]) && $this->server["url"][2] !== str_replace(" ", "-", $post->getSlug()))
                    ) {
                    $this->router->redirect("/posteditor/" . $post->getId() . "/" . str_replace(" ", "-", $post->getSlug()), 301);
                }
                //dd($commentaryList->getCommentaryListForPost($post->getId()));
                echo $this->twig->render('Admins'. DIRECTORY_SEPARATOR . 'PostEditor.twig', ["post" => $post, "commentaries" => $commentaryList->getCommentaryListForPost($post->getId()), "idAuthor" => $_SESSION["user"]->getId()]);
            } else {
                echo $this->twig->render('Admins'. DIRECTORY_SEPARATOR . 'PostEditor.twig', ["idAuthor" => $_SESSION["user"]->getId(), "emptyField" => $emptyField]);
            }
        } else {
            $this->router->redirect("/", 302);
        }
    }
}