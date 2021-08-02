<?php

namespace App\Tests\integrational\App\Application\PdfOrderGenerator;

use App\Infrastructure\PdfOrderGenerator\PdfOrderGenerator;
use Codeception\TestCase\Test;

/**
 * Class PdfOrderGeneratorTest.
 *
 * @package App\Tests\integrational\App\Application\PdfOrderGenerator
 * @covers \App\Infrastructure\PdfOrderGenerator\PdfOrderGenerator
 */
class PdfOrderGeneratorTest extends Test
{
    public function testPdfGeneration()
    {
        $pdfOrderGenerator = $this->getService();
        $result = $pdfOrderGenerator->generatePdfByOrderId(1);

        $this->assertInstanceOf(\SplFileInfo::class, $result);
    }

    /**
     * @return PdfOrderGenerator
     * @throws \Codeception\Exception\ModuleException
     */
    private function getService(): PdfOrderGenerator
    {
        /** @var \Codeception\Module\Symfony $module */
        $module = $this->getModule('Symfony');
        $container = $module->kernel->getContainer();

        return $container->get(PdfOrderGenerator::class);
    }
}
