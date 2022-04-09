<?php

namespace App\Models;
use PDO;

class BlogpostListModel extends Model {
    
    public function getBlogPostList() {
        return  $this->read("blogpost");
    }
}