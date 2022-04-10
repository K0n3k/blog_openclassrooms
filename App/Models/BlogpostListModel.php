<?php

namespace App\Models;

class BlogpostListModel extends Model {
    protected $entity = "App\Entities\blogpostEntity";

    public function getPost(int $id) {
        $post = $this->read("blogpost",["id" => $id]); 
        if(!empty($post)) {
            return $post[0];
        }
        return false;
    }
    public function createPost(array $parameters) {
        $post = $this->create("blogpost", $parameters); 
        if($post) {
            return $this->read("blogpost",$parameters)[0];
        }
        return false;
    }
    public function updatePost(array $values) {
        if(!empty($values["title"])) {
            $sets["title"] = $values["title"];
            $sets["slug"] = str_replace(" ", "-", $values["title"]);
        }
        if(!empty($values["chapo"])) {
            $sets["chapo"] = $values["chapo"];
        }
        if(!empty($values["content"])) {
            $sets["content"] = $values["content"];
        }
        if(!empty($values["lastupdate"])) {
            $sets["lastupdate"] = $values["lastupdate"];
        }
        if(!isset($values["isPublished"])) {
            $sets["isPublished"] = 0;
        } else {
            $sets["isPublished"] = 1;
        }
        if(empty($sets)) {
            return false;
        }
        $post = $this->update("blogpost",["id" => $values["id"]],$sets);
        if(!empty($post)) {
            return $post[0];
        }
        return false;
    }
    public function deletePost(int $id) {
        $post = $this->read("blogpost",["id" => $id]); 
        if(!empty($post)) {
            return $post[0];
        }
        return false;
    }

    public function getBlogPostList() {
        return  $this->read(
            [
                "blogpost",
                "users"
            ],
            [
                "users.id" => "blogpost.idAuthor"
            ],
            [
                "users.firstname",
                "users.lastname",
                "blogpost.*"
            ]);
    }
    public function getBlogPostListPublished() {
        return $this->read(
            [
                "blogpost",
                "users",
            ],
            [
                "isPublished" => true,
                "users.id" => "blogpost.idAuthor",
            ],
            [
                "users.firstname",
                "users.lastname",
                "blogpost.*",
            ]
            );
    }
    public function deleteBlogpost(int $id) {
        return $this->delete("blogpost", ["id" => $id]);
    }

    public function changeisPublishedBlogpost(int $id, int $isPublished) {
        return $this->update("blogpost",["id" => $id], ["isPublished" => $isPublished]);
    }
}