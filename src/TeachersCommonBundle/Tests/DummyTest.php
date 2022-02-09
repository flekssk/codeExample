<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Tests;

use TeachersCommonBundle\Tests\Service\KernelTestCase;

class DummyTest extends KernelTestCase
{
    public function testDummy(): void
    {
        self::assertTrue(true);
    }
}
