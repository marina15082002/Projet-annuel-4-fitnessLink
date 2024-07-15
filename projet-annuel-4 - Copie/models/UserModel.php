<?php

namespace pa\fitnesslink;

require_once 'vendor/autoload.php';

use Aws\Athena\AthenaClient;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;

class UserModel
{
    private string $csvFilePath = 'src/assets/database/database_users.csv';
    private string $parquetFilePath = 'src/assets/database/database_users.parquet';

    public function getUsers(): array
    {
        $parquetModel = new ParquetModel($this->csvFilePath, $this->parquetFilePath);
        $parquetModel->convertParquetToCsv();

        $csvFile = fopen($this->csvFilePath, 'r');

        $users = [];

        while (($data = fgetcsv($csvFile)) !== false) {
            if ($data[0] === 'Role') {
                continue;
            }

            $user = [
                'Role' => $data[0],
                'Name' => $data[1],
                'First_name' => $data[2],
                'Age' => $data[3],
                'Profile_photo' => $data[4],
                'Profession' => $data[5],
                'Specialties' => $data[6],
                'Degrees' => $data[7],
                'Description' => $data[8],
                'Rates' => $data[9],
                'Email' => $data[10],
                'Phone_number' => $data[11],
                'Password' => $data[12],
                'Availability' => $data[13],
                'Country' => $data[14],
                'City' => $data[15],
                'Postal_code' => $data[16],
                'Address' => $data[17]
            ];
            $users[] = $user;
        }

        fclose($csvFile);

        return $users;
    }

    public function getProfessionalsAWS(): array
    {
        $users = $this->getUsersAWS();

        $filteredUsers = array_filter($users, function ($user) {
            return $user['role'] == 2;
        });

        return $filteredUsers;
    }

    private function getUsersAWS(): array
    {
        $stack = HandlerStack::create(new CurlHandler());

        $guzzleClient = new Client([
            'handler' => $stack,
            'verify' => 'cacert.pem'
        ]);

        $athena = new AthenaClient([
            'region'  => 'eu-west-1',
            'version' => 'latest',
            'credentials' => [
                'key'    => 'AKIAQIT2XIQGIH2P4HVM',
                'secret' => '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',
            ],
            'http' => [
                'verify' => 'C:\MAMP\htdocs\projet-annuel-4\cacert.pem'
            ],
            'http_client' => $guzzleClient,
        ]);

        // Démarrer l'exécution de la requête
        $result = $athena->startQueryExecution([
            'QueryString' => 'SELECT * FROM "fitnesswebsite-database"."fitnesswebsite" limit 10',
            'QueryExecutionContext' => [
                'Database' => 'fitnesswebsite-database',
            ],
            'ResultConfiguration' => [
                'OutputLocation' => 's3://fitnesswebsite/',
            ],
        ]);

        $queryExecutionId = $result['QueryExecutionId'];

        while (true) {
            $result = $athena->getQueryExecution([
                'QueryExecutionId' => $queryExecutionId,
            ]);
            $status = $result['QueryExecution']['Status']['State'];
            if ($status === 'SUCCEEDED' || $status === 'FAILED' || $status === 'CANCELLED') {
                break;
            }
            sleep(1);
        }

        $professionals = [];

        if ($status === 'SUCCEEDED') {
            $result = $athena->getQueryResults([
                'QueryExecutionId' => $queryExecutionId,
            ]);

            $rows = array_slice($result['ResultSet']['Rows'], 1);

            $csvFile = fopen('src/assets/database/database_users.csv', 'w');
            fputcsv($csvFile, [
                'role', 'name', 'first_name', 'age', 'profile_photo', 'profession', 'specialties', 'degrees',
                'description', 'rates', 'email', 'phone_number', 'password', 'availability', 'country',
                'city', 'postal_code', 'address', 'partition_0'
            ]);

            foreach ($rows as $row) {
                $professional = [];

                foreach ($row['Data'] as $column) {
                    if (isset($column['VarCharValue'])) {
                        $professional[] = $column['VarCharValue'];
                    } else {
                        $professional[] = '';
                    }
                }
                fputcsv($csvFile, $professional);

                $usersKeys = ['role', 'name', 'first_name', 'age', 'profile_photo', 'profession', 'specialties', 'degrees', 'description', 'rates', 'email', 'phone_number', 'password', 'availability', 'country', 'city', 'postal_code', 'address', 'partition_0'];

                if (count($usersKeys) === count($professional)) {
                    $professionalData = array_combine($usersKeys, $professional);
                    $professionals[] = $professionalData;
                } else {
                    echo 'Error: Number of elements do not match';
                }
            }
            fclose($csvFile);

        } else {
            echo "La requête a échoué avec le statut : $status\n";
        }

        return $professionals;
    }

    public function getProfessionals(): array
    {
        $users = $this->getUsers();
        $professionals = [];

        foreach ($users as $user) {
            if (!empty($user['Profession'])) {
                $professionals[] = $user;
            }
        }

        return $professionals;
    }

    public function getUserByEmail($email)
    {
        $users = $this->getUsers();

        foreach ($users as $user) {
            if ($user['Email'] === $email) {
                return $user;
            }
        }

        return null;
    }

    public function checkEmailPassword($email, $password): array
    {
        $users = $this->getUsers();

        foreach ($users as $user) {
            if ($user['Email'] === $email && $user['Password'] === $password) {
                return [true, $user];
            }
        }

        return [false, ""];
    }

}
?>
