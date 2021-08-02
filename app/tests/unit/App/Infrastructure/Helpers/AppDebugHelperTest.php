<?php

declare(strict_types=1);

namespace App\Tests\unit\App;

use App\Infrastructure\Helpers\AppDebugHelper;
use Codeception\Test\Unit;

class AppDebugHelperTest extends Unit
{
    /**
     * @param $serverAppDebugValue
     * @param $envAppDebugValue
     * @param $environment
     * @param $expectedValue
     * @dataProvider dataProvider
     */
    public function testExtractAppDebugValueShouldReturnCorrectValue(
        $serverAppDebugValue,
        $envAppDebugValue,
        $environment,
        $expectedValue
    ) {
        $result = AppDebugHelper::extractAppDebugValue($serverAppDebugValue, $envAppDebugValue, $environment);

        $this->assertEquals($expectedValue, $result);
    }

    public function dataProvider()
    {
        return [
            //Without env, default values for environments
            [null, null, 'dev', 0],
            [null, null, 'prod', 0],
            [null, null, 'local', 1],
            [null, null, 'unknown-environment', 1],
            //With env APP_DEBUG true/false
            [null, true, 'dev', 1],
            [null, true, 'prod', 1],
            [null, false, 'local', 0],
            //With env APP_DEBUG 1/0
            [null, 1, 'dev', 1],
            [null, 1, 'prod', 1],
            [null, 0, 'local', 0],
            //With $_SERVER['APP_DEBUG'] true/false
            [true, null, 'local', 1],
            [true, null, 'dev', 1],
            [true, null, 'prod', 1],
            [false, null, 'local', 0],
            //With $_SERVER['APP_DEBUG'] 1/0
            [0, null, 'local', 0],
            [1, null, 'local', 1],
        ];
    }
}
