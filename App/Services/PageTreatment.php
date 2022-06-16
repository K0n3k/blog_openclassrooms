<?php

namespace App\Services;

use App\Controllers\Controller;
use App\Enums;
use App\Enums\AdminRestriction;
use App\Enums\AuthorizedMethod;
use App\Sessions\Sessions;

class PageTreatment {

    public function __construct(AuthorizedMethod $method, bool $adminAccess, Controller &$controller) {

        if(Sessions::getUser()->getIsAdmin() && $adminAccess) {
            $method === AuthorizedMethod::GET ? $this->getTreatment() : $this->postTreatment();
        } else {
            //throw forbidden exception
        }

    }

    private function getTreatment() {

    }

    private function postTreatment(string $formAction){
        $formFunction = match($formAction) {
            "createUser" => $this->createUser,
            "updateUser" => $this->updateUser,
            "updateUserIsAdmin" => $this->updateUserIsAdmin,
            "deleteUser" => $this->deleteUser,
            "createPost" => $this->createPost,
            "updatePost" => $this->updatePost,
            "updatePostIsPublished" => $this->updatePostIsPublished,
            "deletePost" => $this->deletePost,
            "createCommentary" => $this->createCommentary,
            "updateCommentaryIsValidated" => $this->updateCommentaryIsValidated,
            "deleteCommentary" => $this->deleteCommentary,
        };

        $formFunction[$formAction]();
    }

    private function createUser() {

    }

    private function updateUser() {

    }

    private function updateUserIsAdmin() {

    }

    private function deleteUser() {

    }
    private function createPost() {

    }

    private function updatePost() {

    }

    private function updatePostIsPublished() {

    }

    private function deletePost() {

    }

    private function createCommentary() {

    }

    private function updateCommentaryIsValidated() {

    }

    private function deleteCommentary() {

    }
}