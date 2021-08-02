<?php

namespace App\Application\PdfOrderGenerator;

use SplFileInfo;

/**
 * Interface PdfOrderGeneratorInterface.
 *
 * @package App\Application\PdfOrderGenerator
 */
interface PdfOrderGeneratorInterface
{
    /**
     * Генерация PDF файла для приказа.
     *
     * @param int $id
     *
     * @return SplFileInfo
     */
    public function generatePdfByOrderId(int $id): SplFileInfo;
}
