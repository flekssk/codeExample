<?php

namespace App\Tests\unit\App\Application\FileGenerator;

use App\Infrastructure\FileGenerator\FileGeneratorService;
use Codeception\TestCase\Test;

/**
 * Class FileGeneratorServiceTest.
 *
 * @package App\Tests\unit\App\Application\FileGenerator
 * @covers \App\Infrastructure\FileGenerator\FileGeneratorService
 */
class FileGeneratorServiceTest extends Test
{

    public function testGeneratePdf()
    {
        $content = 'Test string';
        $fileGenerator = new FileGeneratorService();
        $fileGenerator->generatePdf($content);

        $fileName = sha1($content) . '.pdf';
        $this->assertFileExists("/tmp/{$fileName}");
    }
}
