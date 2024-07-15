<?php

namespace pa\fitnesslink;

class AppointmentsModel
{
    private string $csvFilePath = 'src/assets/database/database_appointments.csv';
    private string $parquetFilePath = 'src/assets/database/database_appointments.parquet';
    private ParquetModel $parquetModel;

    public function __construct()
    {
        $this->parquetModel = new ParquetModel($this->csvFilePath, $this->parquetFilePath);
    }

    public function writingToCsv($professional, $particular, $date, $hours) {
        $header = ['Professional', 'Particular', 'Date', 'Hours'];
        $data = [[$professional, $particular, $date, $hours]];
        $this->parquetModel->writingToCsv($header, $data);
        $this->parquetModel->convertCsvToParquet();
    }

    public function checkAppointmentInParquet($professional, $particular, $date, $hours): bool
    {
        $this->parquetModel->convertParquetToCsv();
        $csvFile = fopen($this->csvFilePath, 'r');

        while (($row = fgetcsv($csvFile)) !== false) {
            if ($row[0] == $professional && $row[1] == $particular && $row[2] == $date && $row[3] == $hours) {
                fclose($csvFile);
                return true;
            }
        }

        fclose($csvFile);
        return false;
    }
}