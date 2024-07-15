<?php

/**
 * @file
 * IndexController class file.
 */

declare(strict_types=1);

namespace pa\fitnesslink;

class ProfilController
{
    public function get()
    {
        $route = $_REQUEST["route"] ?? "";
        include "./src/profil.php";
    }

    public function modify()
    {
        $this->checkInputs();

        header("Location: /Projet-annuel-4/profil");
        header("Connection: close");
        exit;
    }

    private function checkInputs()
    {
        $role = 'pro';
        $body = $_POST;

        if(!isset($body['inputBirthday']) || empty($body['inputBirthday'])) {
            header("Location: /Projet-annuel-4/profil?birthdayEmptyError=true");
            exit;
        }

        if(!isset($body['inputEmail']) || empty($body['inputEmail'])) {
            header("Location: /Projet-annuel-4/profil?emailEmptyError=true");
            exit;
        }

        if (!filter_var($body['inputEmail'], FILTER_VALIDATE_EMAIL)) {
            header("Location: /Projet-annuel-4/profil?emailSyntaxError=true");
            exit;
        }

        $pattern = "#^(0|\\+33|0033)[1-9][0-9]{8}$#";
        if ($role == 'pro' && (isset($body['phone']) && !empty($body['phone']) && preg_match($pattern, $body['phone']) == 0)) {
            header("Location: /Projet-annuel-4/profil?phoneSyntaxError=true");
            exit;
        }

        if ($role == 'pro' && (!isset($body['inputJob']) || empty($body['inputJob']))) {
            header("Location: /Projet-annuel-4/profil?jobEmptyError=true");
            exit;
        }

        if ($role == 'pro' && (!isset($body['inputCountry']) || empty($body['inputCountry']))) {
            header("Location: /Projet-annuel-4/profil?countryEmptyError=true");
            exit;
        }

        if($role == 'pro' && (!isset($body['inputCity']) || empty($body['inputCity']))) {
            header("Location: /Projet-annuel-4/profil?cityEmptyError=true");
            exit;
        }

        if($role == 'pro' && (!isset($body['inputPostalCode']) || empty($body['inputPostalCode']))) {
            header("Location: /Projet-annuel-4/profil?postalCodeEmptyError=true");
            exit;
        }

        $pattern = '/^\d{5}$/';
        if ($role == 'pro' && (isset($body['inputPostalCode']) && !empty($body['inputPostalCode']) && preg_match($pattern, $body['inputPostalCode']) == 0)) {
            header("Location: /Projet-annuel-4/profil?postalCodeSyntaxError=true");
            exit;
        }
    }
}