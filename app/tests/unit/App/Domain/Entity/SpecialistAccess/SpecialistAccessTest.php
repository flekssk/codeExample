<?php

namespace App\Tests\unit\App\Domain\Entity\SpecialistAccess;

use App\Domain\Entity\SpecialistAccess\SpecialistAccess;
use Codeception\Test\Unit;

/**
 * Class SpecialistAccessTest.
 *
 * @package App\Tests\unit\App\Domain\Entity\SpecialistAccess
 * @covers  \App\Domain\Entity\SpecialistAccess\SpecialistAccess
 */
class SpecialistAccessTest extends Unit
{

    /**
     * Test create entity.
     */
    public function testCreateEntity()
    {
        $document = new SpecialistAccess();
        $document->setId(1);
        $document->setSpecialistId(100666);
        $document->setProductId(1);
        $document->setDateStart(new \DateTimeImmutable('2020-01-01'));
        $document->setDateEnd(new \DateTimeImmutable('2020-01-02'));


        $this->assertEquals(1, $document->getId());
        $this->assertEquals(100666, $document->getSpecialistId());
        $this->assertEquals(1, $document->getProductId());
        $this->assertEquals('2020-01-01', $document->getDateStart()->format('Y-m-d'));
        $this->assertEquals('2020-01-02', $document->getDateEnd()->format('Y-m-d'));
    }
}
