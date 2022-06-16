<?php

namespace App\Enums;

enum UserFields : string {
    case id = "id";
    case email = "email";
    case password = "password";
    case firstname = "firstname";
    case lastname = "lastname";
    case isAdmin = "isAdmin";
}