<?php

namespace App\Infrastructure\FileGenerator;

use App\Application\FileGenerator\Exception\FileGeneratorException;
use App\Application\FileGenerator\FileGeneratorServiceInterface;
use mikehaertl\wkhtmlto\Pdf;
use mikehaertl\wkhtmlto\Image;

/**
 * Class FileGeneratorService.
 *
 * @package App\Application\FileGenerator
 */
class FileGeneratorService implements FileGeneratorServiceInterface
{
    private const TMP_DIR = '/tmp';

    /**
     * @var Pdf
     */
    private Pdf $pdf;

    /**
     * @var string
     */
    private string $outputFile;

    /**
     * FileGeneratorService initialization.
     *
     * @param string $content
     */
    private function init(string $content): void
    {
        $this->pdf = new Pdf(
            [
                'user-style-sheet' => '/var/www/src/Infrastructure/FileGenerator/assets/default/css/styles.css',
            ]
        );
        $this->pdf->setOptions(
            [
                'commandOptions' => [
                    'enableXvfb' => true,
                ],
                'margin-top' => 10,
                'margin-bottom' => 10,
            ]
        );

        $fileName = sha1($content) . '.pdf';
        $this->outputFile = self::TMP_DIR . DIRECTORY_SEPARATOR . $fileName;
    }

    /**
     * @inheritDoc
     */
    public function generatePdf(string $content): string
    {
        $this->init($content);

        $result = $this->pdf->addPage($content)->saveAs($this->outputFile);
        if (!$result) {
            throw new FileGeneratorException($this->pdf->getError());
        }

        return $this->outputFile;
    }

    /**
     * @inheritDoc
     */
    public function generateImage(string $content): string
    {
        $image = new Image($content);
        $image->setOptions(
            [
                'commandOptions' => [
                    'enableXvfb' => true,
                ],
                'quality' => 100,
                'zoom' => 2,
            ]
        );
        $fileName = self::TMP_DIR . DIRECTORY_SEPARATOR . sha1($content) . '.png';
        if ($image->saveAs($fileName) === false) {
            throw new FileGeneratorException($image->getError());
        }

        // Команда, генерирующая изображение, не применяет никакого сжатия к получившемуся изображению,
        // поэтому необходимо применить компрессию после генерации, что уменьшает размер получившегося файла
        // с 12 мб до (примерно) 1.3 мб без видимых потерь в качестве.
        $image = imagecreatefrompng($fileName);
        imagepng($image, $fileName, 9);

        return $fileName;
    }
}
