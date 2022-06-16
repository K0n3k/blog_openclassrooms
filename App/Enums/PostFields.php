<?php

namespace App\Enums;

enum PostFields : string {

    case id = "id";
    case idAuthor = "idAuthor";
    case title = "title";
    case slug = "slug";
    case chapo = "chapo";
    case content = "content";
    case publishedDate = "publishedDate";
    case lastUpdate = "lastUpdate";
    case isPublished = "isPublished";

}