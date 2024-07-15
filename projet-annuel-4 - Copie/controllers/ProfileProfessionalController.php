<?php

declare(strict_types=1);

namespace pa\fitnesslink;

require_once 'vendor/autoload.php';

use pa\fitnesslink\UserModel;

class ProfileProfessionalController
{
    public function get($email) {
        $route = $_REQUEST["route"] ?? "";
        $userModel = new UserModel();
        $email = $_GET['email'] ?? '';

        if (!empty($email)) {
            $user = $userModel->getUserByEmail($email);

            if ($user !== null) {
                include "./src/profile_professional.php";
            } else {
                header("Location: /");
                exit();
            }
        } else {
            header("Location: /");
            exit();
        }
    }
}