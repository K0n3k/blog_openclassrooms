<?php

namespace App\Models;

use App\Entitys\PostEntity;
use App\Entitys\Entity;
use App\Enums\PostFields;
use App\Enums\SqlTables;
use App\Enums\UserFields;

class PostsModel extends Model {
    
    public function __construct() {
        parent::__construct();

        $this->entity = "App\Entitys\PostEntity";        
    }

    public function createPost(PostEntity $blogpost) {
        return $this->insert(SqlTables::blogpost, $blogpost);

    }

    public function readPost(int $postId): PostEntity {
        return $this
        ->select([SqlTables::blogpost->name])
        ->where(SqlTables::blogpost->name.".".PostFields::id->name, $postId)
        ->exec()[0];
    }

    public function readPostPublished(int $postId) {
        $post = $this
        ->select([
            SqlTables::blogpost->name,
            SqlTables::users->name,
        ],[
            SqlTables::blogpost->name.".*",
            SqlTables::users->name.".". UserFields::firstname->name,
            SqlTables::users->name.".". UserFields::lastname->name,
        ])
        ->where(SqlTables::blogpost->name.".".PostFields::id->name, $postId)
        ->where(SqlTables::users->name.".".UserFields::id->name, SqlTables::blogpost->name.".".PostFields::idAuthor->name)
        ->where(PostFields::isPublished->name, (int)true)
        ->exec();

        return empty($post) ? false : $post[0];
    }

    public function updatePost(PostEntity $postEntity): PostEntity {
        $blogpost = (array)$postEntity;
        foreach($blogpost as $valKey => $val) {
            if($val !== "") { 
                $blogpost += [substr_replace($valKey,"",0,strpos($valKey,"\x00", 1)+1) => $val];
            }
            unset($blogpost[$valKey]); 
        }
        //dd($postEntity->getId());
        $this
        ->update(SqlTables::blogpost->name,$blogpost)
        ->where(PostFields::id->name,"'". (string)$postEntity->getId() ."'")
        ->exec();

        return $this->readPost($postEntity->getId());
    }

    public function updatePostIsPublished(int $postId, bool $isPublished) {
        return $this
        ->update(
            SqlTables::blogpost->name,
            [PostFields::isPublished->name => (int)$isPublished])
        ->where(PostFields::id->name, $postId)
        ->exec();
    }

    public function deletePost(int $id) {
        return $this
        ->delete(SqlTables::blogpost->name)
        ->where(PostFields::id->name, $id)
        ->exec();
    }
    
    public function readPostList() {
        return $this
        ->select([
            SqlTables::blogpost->name,
            SqlTables::users->name,
        ],[
            SqlTables::blogpost->name . ".*",
            SqlTables::users->name . "." . UserFields::firstname->name,
            SqlTables::users->name . "." . UserFields::lastname->name,
        ])
        ->where(
            SqlTables::blogpost->name . "." . PostFields::idAuthor->name,
            SqlTables::users->name . "." . UserFields::id->name,
        )
        ->exec(); 
    }

    public function readPostListPublished() {
        return $this
        ->select([
            SqlTables::blogpost->name,
            SqlTables::users->name,
        ],[
            SqlTables::blogpost->name . ".*",
            SqlTables::users->name . "." . UserFields::firstname->name,
            SqlTables::users->name . "." . UserFields::lastname->name,
        ])
        ->where(
            PostFields::isPublished->name,
            true,
        )
        ->where(
            SqlTables::blogpost->name . "." . PostFields::idAuthor->name,
            SqlTables::users->name . "." . UserFields::id->name,
        )
        ->exec();      
    }
}