<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);
$route = $_REQUEST["route"] ?? "";
$method = $_SERVER["REQUEST_METHOD"];


if ($route == "") {
    include "./controllers/IndexController.php";
    $controller = new pa\fitnesslink\IndexController();
    if ($method == "GET") {
        $controller->get();
        die();
    }
}

if (preg_match("/^login/", $route)) {
    include "./controllers/LoginController.php";
    $controller = new pa\fitnesslink\LoginController();
    if ($method == "GET") {
        $controller->get();
        die();
    }

    if ($method == "POST") {
        $controller->post();
        die();
    }
}

if (preg_match("/^profil_professionnel/", $route)) {
    include "./controllers/ProfileProfessionalController.php";
    $controller = new pa\fitnesslink\ProfileProfessionalController();
    if ($method == "GET") {
        $controller->get($_GET['email'] ?? '');
        die();
    }
}

if (preg_match("/^profil/", $route)) {
    include "./controllers/ProfilController.php";
    $controller = new pa\fitnesslink\ProfilController();
    if ($method == "GET") {
        $controller->get();
        die();
    }

    if ($method == "POST") {
        $controller->modify();
        die();
    }
}

if (preg_match("/^making_appointments/", $route)) {
    include "./controllers/MakingAppointmentsController.php";
    $controller = new pa\fitnesslink\MakingAppointmentsController();
    if ($method == "GET") {
        $controller->get($_GET['email'] ?? '');
        die();
    }

    if ($method == "POST") {
        $controller->post($_GET['email'] ?? '');
    }
}

if (preg_match("/^chatbot/", $route)) {
    include "./controllers/ChatbotController.php";
    $controller = new pa\fitnesslink\ChatbotController();
    if ($method == "POST") {
        $controller->post();
    }
}

die();

?>