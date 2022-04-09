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
}