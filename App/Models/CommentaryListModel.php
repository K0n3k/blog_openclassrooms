<?php

namespace App\Models;
use PDO;

class CommentaryListModel extends Model {
    protected $entity = "App\Entities\CommentaryEntity";

    public function getCommentaryList() {
        return $this->read(
            [
                "commentary",
                "blogpost",
            ],
            [
                "commentary.idBlogpost" => "blogpost.id",
            ],
            [
                "commentary.*",
                "blogpost.title",
                "blogpost.slug",
            ]
        );
    }
    public function getCommentaryListForPost($postId) {
        return $this->read("commentary", ["idBlogpost" => $postId]);
    }

    public function deleteCommentary(int $id) {
        return $this->delete("commentary", ["id" => $id]);
    }

    public function changeisValidatedCommentary(int $id, int $isValidated) {
        return $this->update("commentary",["id" => $id], ["isValidated" => $isValidated]);
    }
}