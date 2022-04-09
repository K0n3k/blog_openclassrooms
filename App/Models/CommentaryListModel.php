<?php

namespace App\Models;
use PDO;

class CommentaryListModel extends Model {
    protected $entity = "App\Entities\CommentaryEntity";

    public function getCommentaryList() {
        return $this->read("commentary");
    }
}