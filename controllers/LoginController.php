<?php

/**
 * @file
 * LoginController class file.
 */

declare(strict_types=1);

namespace pa\fitnesslink;

include_once "models/UserModel.php";

class LoginController
{
    public function get()
    {
        $route = $_REQUEST["route"] ?? "";
        include "./src/login.php";
    }

    public function post()
    {
        $userModel = new UserModel();
        $body = $_POST;

        $res = $userModel->checkEmailPassword($body['email'], hash("sha256", $body["password"]));

        if (!$res[0]) {
            header("Location: /Projet-annuel-4/login?loginError=true");
            exit;
        } else {
            session_start();
            $_SESSION["Role"] = $res[1][0]["Role"];
            $_SESSION["Email"] = $body["email"];
            $_SESSION["Name"] = $res[1][0]["Name"];
            $_SESSION["First_name"] = $res[1][0]["First_name"];
            $_SESSION["Age"] = $res[1][0]["Age"];
            $_SESSION["Profile_photo"] = $res[1][0]["Profile_photo"];
            $_SESSION["Profession"] = $res[1][0]["Profession"];
            $_SESSION["Specialties"] = $res[1][0]["Specialties"];
            $_SESSION["Degrees"] = $res[1][0]["Degrees"];
            $_SESSION["Description"] = $res[1][0]["Description"];
            $_SESSION["Rates"] = $res[1][0]["Rates"];
            $_SESSION["Phone_number"] = $res[1][0]["Phone_number"];
            $_SESSION["Availability"] = $res[1][0]["Availability"];
            $_SESSION["Country"] = $res[1][0]["Country"];
            $_SESSION["City"] = $res[1][0]["City"];
            $_SESSION["Postal_code"] = $res[1][0]["Postal_code"];
            $_SESSION["Address"] = $res[1][0]["Address"];
            header("Location: /Projet-annuel-4/");
            exit;
        }
    }
}