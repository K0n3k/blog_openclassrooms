<?php

namespace App\Controllers;

use App\Models\BlogpostListModel;

class BlogpostListController extends Controller {

    public function render() {
        if(array_key_exists("user", $_SESSION) && $_SESSION["user"]->getIsAdmin()) {

            $blogpostList = new BlogpostListModel();
            
            if (array_key_exists("parameters", $this->server)) {
                switch($this->server["parameters"]["action"]) {
                    case "delete" :
                        $blogpostList->deleteBlogPost($this->server["parameters"]["id"]);
                        $this->router->redirect("/blogpostList", 302);
                        break;
                    case "update" :
                        $isPublished = !$this->server["parameters"]["isPublished"];
                        $blogpostList->changeisPublishedBlogpost($this->server["parameters"]["id"], $isPublished);
                        $this->router->redirect("/blogpostList", 302);
                        break;
                    default:
                        $this->router->redirect("/blogpostList", 302);
                        break;
                }
            }


            echo $this->twig->render('Admins'. DIRECTORY_SEPARATOR . 'BlogpostList.twig', [
                "posts" => $blogpostList->getBlogPostList(),
            ]);
        } else {
            $this->router->redirect("/", 302);
        }
    }

}