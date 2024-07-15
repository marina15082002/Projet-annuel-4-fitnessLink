<?php

declare(strict_types=1);

namespace pa\fitnesslink;

require_once 'vendor/autoload.php';

use pa\fitnesslink\UserModel;

class IndexController
{
    public function get()
    {
        $route = $_REQUEST["route"] ?? "";
        $userModel = new UserModel();
        //$users = $userModel->getProfessionals();
        $users = $userModel->getProfessionalsAWS();

        include "./src/accueil.php";
    }
}
