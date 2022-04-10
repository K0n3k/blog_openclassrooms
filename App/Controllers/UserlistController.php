<?php

namespace App\Controllers;

use App\Models\UserlistModel;

class UserlistController extends Controller {

    public function render() {

        if(array_key_exists("user", $_SESSION) && $_SESSION["user"]->getIsAdmin()) {
            $userList = new UserlistModel();
            if (array_key_exists("parameters", $this->server)) {
                switch($this->server["parameters"]["action"]) {
                    case "delete" :
                        $userList->deleteUser($this->server["parameters"]["id"]);
                        $this->router->redirect("/userlist", "302");
                        break;
                    case "updateIsAdmin" :
                        $isAdmin = !$this->server["parameters"]["isAdmin"];
                        $userList->changeIsAdminUser($this->server["parameters"]["id"], $isAdmin);
                        $this->router->redirect("/userlist", 302);
                        break;
                        case "updateUser" :
                            $userList->changeUserValues($this->server["parameters"]["id"],
                             [
                                 "email" => $this->server["parameters"]["email"],
                                 "password" => $this->server["parameters"]["password"],
                                 "firstname" => $this->server["parameters"]["firstname"],
                                 "lastname" => $this->server["parameters"]["lastname"],
                             ]);
                            $this->router->redirect("/userlist", 302);
                            break;
                    default:
                        $this->router->redirect("/userlist", 302);
                        break;
                }
            }
            echo $this->twig->render('Admins'. DIRECTORY_SEPARATOR . 'UsersList.twig', [
                "users" => $userList->getUserList(),
            ]);
        } else {
            $this->router->redirect("/", 302);
        }
    }

}