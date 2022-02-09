<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Tests\Service;

use DG\BypassFinals;
use PHPUnit\Runner\BeforeTestHook;

final class BypassFinalHook implements BeforeTestHook
{

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
     */
    public function executeBeforeTest(string $test): void
    {
        BypassFinals::enable();
    }
}
