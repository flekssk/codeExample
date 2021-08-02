<?php

declare(strict_types=1);

namespace App\Infrastructure\Helpers;

class AppDebugHelper
{
    /**
     * @param mixed $serverAppDebugValue
     * @param mixed $envAppDebugValue
     * @param mixed $environment
     * @return string
     */
    public static function extractAppDebugValue(
        $serverAppDebugValue,
        $envAppDebugValue,
        $environment
    ): string {
        $serverAppDebugValue = $serverAppDebugValue ?? $envAppDebugValue ?? !in_array($environment, ['prod', 'dev'], true);

        return (int) $serverAppDebugValue || filter_var($serverAppDebugValue, FILTER_VALIDATE_BOOLEAN) ? '1' : '0';
    }
}
