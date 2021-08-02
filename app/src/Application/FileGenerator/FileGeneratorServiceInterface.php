<?php

namespace App\Application\FileGenerator;

use App\Application\FileGenerator\Exception\FileGeneratorException;

/**
 * Interface FileGeneratorServiceInterface.
 *
 * @package App\Application\FileGenerator
 */
interface FileGeneratorServiceInterface
{
    /**
     * @param string $content
     *
     * @return string
     *   Путь до сохраненного файла.
     *
     * @throws FileGeneratorException
     */
    public function generatePdf(string $content): string;

    /**
     * @param string $content
     * @return string
     *
     * @throws FileGeneratorException
     */
    public function generateImage(string $content): string;
}
