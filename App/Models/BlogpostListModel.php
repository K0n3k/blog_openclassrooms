<?php

namespace App\Models;

class BlogpostListModel extends Model {
    
    public function getBlogPostList() {
        return  $this->read(
            [
                "blogpost",
                " users"
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