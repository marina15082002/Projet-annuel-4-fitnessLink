<?php

declare(strict_types=1);

namespace pa\fitnesslink;

require_once 'vendor/autoload.php';

use pa\fitnesslink\UserModel;

class ChatbotController
{
    private string $pythonInterpreter = '.venv/Scripts/python.exe';

    public function post()
    {
        $data = array(
            "inputImproveSkill" => $_POST["inputImproveSkill"] ?? '',
            "inputLosingWeight" => $_POST["inputLosingWeight"] ?? '',
            "inputAvailableWeek" => $_POST["inputAvailableWeek"] ?? '',
            "inputBudget" => $_POST["inputBudget"] ?? '',
            "inputDescribeSportCoach" => $_POST["inputDescribeSportCoach"] ?? '',
            "inputInterresantSportingActivity" => $_POST["inputInterresantSportingActivity"] ?? '',
        );

        $jsonData = json_encode($data, JSON_PRETTY_PRINT);
        $filePath = 'src/assets/database/chatbot_input.json';
        file_put_contents($filePath, $jsonData);


        $pythonInterpreter = '.venv/Scripts/python.exe';
        $pythonScriptPath = 'src/library/models/recommendation.py';

        $command = '"' . $pythonInterpreter . '" "' . $pythonScriptPath . '"';
        $output = shell_exec($command . ' 2>&1');


        $csvFile = 'src/assets/database/chatbot_output.csv';

        if (!file_exists($csvFile)) {
            die("Le fichier CSV des résultats filtrés n'existe pas.");
        }

        $handle = fopen($csvFile, 'r');
        if ($handle === false) {
            die("Erreur lors de l'ouverture du fichier CSV.");
        }

        $results = [];

        while (($data = fgetcsv($handle)) !== false) {
            $results[] = $data;
        }

        fclose($handle);

        echo "<h1>Résultats filtrés</h1>";
        echo "<table border='1'>";
        echo "<tr><th>Nom</th><th>Spécialités</th><th>Prix</th></tr>";

        foreach ($results as $row) {
            echo "<tr>";
            foreach ($row as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
            }
            echo "</tr>";
        }

        echo "</table>";

    }
}
