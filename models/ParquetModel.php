<?php

namespace pa\fitnesslink;

require_once 'vendor/autoload.php';

class ParquetModel
{
    private string $csvFilePath;
    private string $parquetFilePath;
    private string $pythonInterpreter = '.venv/Scripts/python.exe';

    public function __construct($csvFilePath, $parquetFilePath)
    {
        $this->csvFilePath = $csvFilePath;
        $this->parquetFilePath = $parquetFilePath;
    }

    public function convertCsvToParquet() {
        $pythonInterpreter = $this->pythonInterpreter;
        $pythonScriptPath = 'src/library/convert_csv_to_parquet.py';
        $parquetFilePath = $this->parquetFilePath;
        $csvFilePath = $this->csvFilePath;

        $command = '"' . $pythonInterpreter . '" "' . $pythonScriptPath . '" "' . $csvFilePath . '" "' . $parquetFilePath . '"';

        shell_exec($command . ' 2>&1');
    }

    public function convertParquetToCsv()
    {
        $pythonInterpreter = $this->pythonInterpreter;
        $pythonScriptPath = 'src/library/convert_parquet_to_csv.py';
        $parquetFilePath = $this->parquetFilePath;
        $csvFilePath = $this->csvFilePath;

        $command = '"' . $pythonInterpreter . '" "' . $pythonScriptPath . '" "' . $parquetFilePath . '" "' . $csvFilePath . '"';

        shell_exec($command . ' 2>&1');
    }

    public function writingToCsv($header, $data) {
        if (!file_exists($this->csvFilePath)) {
            $file = fopen($this->csvFilePath, 'w');
            fputcsv($file, $header);

            foreach ($data as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        } else {
            $file = fopen($this->csvFilePath, 'a');

            foreach ($data as $row) {
                fputcsv($file, $row);
            }

            fclose($file);
        }
    }
}