<?php

namespace App\Models;

use App\Entitys\CommentaryEntity as CommentaryEntity;
use App\Enums\SqlTables;
use App\Enums\CommentaryFields;
use App\Enums\PostFields;

class CommentarysModel extends Model {

    public function __construct() {
        parent::__construct();

        $this->entity = "App\Entitys\CommentaryEntity";        
    }

    public function createCommentary(CommentaryEntity $commentary) {
        
        return $this->insert(SqlTables::commentary, $commentary);

    }

    public function updateCommentaryIsValidated(int $commentaryId, bool $isValidated) : array|false {
        return $this
        ->update(
            SqlTables::commentary->name,
            [CommentaryFields::isValidated->name => (int)$isValidated])
        ->where(PostFields::id->name, $commentaryId)
        ->exec();
    }

    public function deleteCommentary(int $id) {
        return $this
        ->delete(SqlTables::commentary->name)
        ->where(CommentaryFields::id->name, $id)
        ->exec();
    }

    public function readPostCommentaryList(int $idPost) {
        return $this
        ->select([SqlTables::commentary->name])
        ->where(CommentaryFields::idBlogpost->name, $idPost)
        ->exec();
    }

    public function readCommentaryList() {
        return $this
        ->select([
            SqlTables::commentary->name,
            SqlTables::blogpost->name,
        ],[
            SqlTables::commentary->name.".*",
            SqlTables::blogpost->name.".".PostFields::title->name,
        ])
        ->where(
            SqlTables::commentary->name.".".CommentaryFields::idBlogpost->name,
            SqlTables::blogpost->name.".".PostFields::id->name)
        ->exec(); 
    }

    public function readCommentaryListValidated(int $postId) {
        return $this
        ->select([
            SqlTables::commentary->name,
        ],[
            SqlTables::commentary->name.".*",
        ])
        ->where(SqlTables::commentary->name.".".CommentaryFields::idBlogpost->name,$postId)
        ->where(SqlTables::commentary->name.".".CommentaryFields::isValidated->name, (int)true)
        ->exec(); 
    }
}