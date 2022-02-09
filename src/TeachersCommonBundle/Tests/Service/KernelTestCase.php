<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase as BaseKernelTestCase;

abstract class KernelTestCase extends BaseKernelTestCase
{
    // phpcs:ignore SlevomatCodingStandard.Classes.TraitUseSpacing.IncorrectLinesCountAfterLastUse
    use MemoryLeakingPreventTrait;

    /**
     * @param string[] $a
     * @param string[] $b
     */
    protected static function assertArraysEqual(array $a, array $b): void
    {
        sort($a);
        sort($b);

        self::assertEquals($a, $b);
    }
}
