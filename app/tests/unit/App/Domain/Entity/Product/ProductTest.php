<?php

namespace App\Tests\unit\App\Domain\Entity\Product;

use App\Domain\Entity\Product\Product;
use Codeception\Test\Unit;

/**
 * Class ProductTest.
 *
 * @covers \App\Domain\Entity\Product\Product
 */
class ProductTest extends Unit
{
    /**
     * Test create product.
     */
    public function testCreateProduct()
    {
        $position = new Product();
        $position->setId(1);
        $position->setName("name");

        $this->assertEquals(1, $position->getId());
        $this->assertEquals("name", $position->getName());
    }
}
