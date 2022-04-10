<?php

namespace App\Controllers;

use App\Models\CommentaryListModel;

class CommentaryListController extends Controller {

    public function render() {

        if(array_key_exists("user", $_SESSION) && $_SESSION["user"]->getIsAdmin()) {

            $commentaryList = new CommentaryListModel();

            if (array_key_exists("parameters", $this->server)) {
                switch($this->server["parameters"]["action"]) {
                    case "delete" :
                        $commentaryList->deleteCommentary($this->server["parameters"]["id"]);
                        $this->router->redirect("/commentarylist", "302");
                        break;
                    case "update" :
                        $isValidated = !$this->server["parameters"]["isValidated"];
                        $commentaryList->changeisValidatedCommentary($this->server["parameters"]["id"], $isValidated);
                        $this->router->redirect("/commentarylist", "302");
                        break;
                    default:
                        $this->router->redirect("/commentarylist", 302);
                        break;
                }
            }
            
            echo $this->twig->render('Admins'. DIRECTORY_SEPARATOR . 'CommentaryList.twig', [
                "commentaries" => $commentaryList->getCommentaryList(),
            ]);
        } else {
            $this->router->redirect("/", 302);
        }
    }

}