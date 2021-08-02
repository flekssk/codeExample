<?php

namespace App\Tests\unit\App\Infrastructure\EntityRevisions\Helper;

use App\Infrastructure\EntityRevisions\Helper\FormatterTrait;
use Codeception\TestCase\Test;
use DateTimeImmutable;

/**
 * Class FormatterTraitTest.
 *
 * @package App\Tests\unit\App\Infrastructure\EntityRevisions\Helper
 */
class FormatterTraitTest extends Test
{
    use FormatterTrait;

    /**
     * @throws \Exception
     */
    public function testDateTimeFormatterCallback(): void
    {
        $result = $this->dateTimeFormatterCallback(new DateTimeImmutable(), null, '');

        $testDateTimeObject = new DateTimeImmutable($result);

        $this->assertIsString($result);
        $this->assertInstanceOf(DateTimeImmutable::class, $testDateTimeObject);
    }
}
