<?php

declare(strict_types=1);

namespace pa\fitnesslink;

require_once 'vendor/autoload.php';

use pa\fitnesslink\UserModel;
use pa\fitnesslink\AppointmentsModel;
use DateTime;

class MakingAppointmentsController
{
    public function get($email)
    {
        $userModel = new UserModel();
        $user = $userModel->getUserByEmail($email);

        if ($user !== null) {
            $available = $this->getNextAvailableDays($user['Availability'], 14);
            $availableDays = $available[0];
            $availableTime = $available[1];
            $email = $_GET['email'] ?? '';
            include "./src/making_appointments.php";
        } else {
            header("Location: /");
            exit();
        }
    }

    public function getNextAvailableDays($availability, $numDays): array
    {
        $availableDays = [];
        $availableTime = [];
        $availability = explode(';', $availability);
        array_pop($availability);

        $availableWeekDays = [];
        $availableWeekTime = [];

        foreach ($availability as $schedule) {
            $scheduleParts = explode(':', $schedule);
            $dayAvailability = trim($scheduleParts[0]);
            $day = $dayAvailability;
            $availableWeekDays[] = $day;

            $timeAvailability = trim($scheduleParts[1]);
            $time = $timeAvailability;
            $availableWeekTime[] = $time;
        }

        $days = array(
            'Monday' => 'Lundi',
            'Tuesday' => 'Mardi',
            'Wednesday' => 'Mercredi',
            'Thursday' => 'Jeudi',
            'Friday' => 'Vendredi',
            'Saturday' => 'Samedi',
            'Sunday' => 'Dimanche'
        );

        $date = new DateTime();
        $dayEN = date('l');
        $dayFR = $days[$dayEN];

        while (count($availableDays) < $numDays) {
            if (in_array($dayFR, $availableWeekDays)) {
                $availableDays[count($availableDays) - 1]  = $date->format('l j F Y');
                $availableTime[count($availableDays) - 1] = $availableWeekTime[array_search($dayFR, $availableWeekDays)];
            }
            $date->modify('+1 day');
            $dayEN = date('l', strtotime($dayEN . ' +1 day'));
            $dayFR = $days[$dayEN];
        }


        return [$availableDays, $availableTime];
    }

    public function post($email)
    {
        session_start();
        if (!isset($_SESSION["Email"])) {
            header("Location: /Projet-annuel-4/login/");
            exit();
        }

        $appointmentsModel = new AppointmentsModel();
        $selectedDate = $_POST['selectedDate'];
        $inputHour = $_POST['inputHour'];

        $appointmentsModel->writingToCsv($email, $_SESSION["Email"], $selectedDate, $inputHour);
        $success = $appointmentsModel->checkAppointmentInParquet($email, $_SESSION["Email"], $selectedDate, $inputHour);
        if (!$success) {
            header("Location: /Projet-annuel-4/making_appointments/?" . $email . "&error=1");
            exit();
        }

        header("Location: /Projet-annuel-4/?success=1");
        exit();

    }


}
