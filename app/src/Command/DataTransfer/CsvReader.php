<?php

namespace App\Command\DataTransfer;

use Exception;
use Generator;

/**
 * Class CsvReader.
 *
 * @package App\Command\DataTransfer
 */
class CsvReader
{
    /**
     * @var string
     */
    private string $filePath;

    /**
     * @var array
     */
    private array $header;

    /**
     * CsvReader constructor.
     *
     * @param string $filePath
     *
     * @throws Exception
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $file = fopen($this->filePath, "r");
        if ($file) {
            $firstLine = fgets($file);
            if (!$firstLine) {
                throw new Exception("Файл '{$filePath}' не найден.");
            }

            $this->header = str_getcsv($firstLine);

            fclose($file);
        }
    }

    /**
     * @return Generator
     */
    public function getData(): Generator
    {
        $file = fopen($this->filePath, "r");
        if ($file) {
            while (($line = fgets($file)) !== false) {
                $data = str_getcsv($line);

                if ($data === $this->header) {
                    continue;
                }

                $data = array_combine($this->header, $data);

                yield $data;
            }

            fclose($file);
        }

        return;
    }
}
