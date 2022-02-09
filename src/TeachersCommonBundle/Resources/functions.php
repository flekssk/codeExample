<?php

declare(strict_types=1);

if (!function_exists('convertToPostgresArray')) {
    /**
     * @param mixed $value
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint.DisallowedMixedTypeHint
     */
    function convertToPostgresArray($value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (!is_array($value)) {
            $value = [$value];
        }

        $result = [];

        foreach ($value as $item) {
            if ($item === null) {
                $item = 'NULL';
            }

            if ($item === '') {
                $item = '""';
            }

            $result[] = '"' . addcslashes(str_replace(',', '\,', $item), '"') . '"';
        }

        return '{' . implode(',', $result) . '}';
    }

}

if (!function_exists('convertFromPostgresArray')) {
    /**
     * @return string[]|null
     *
     * @psalm-suppress InvalidReturnType
     * @psalm-suppress InvalidReturnStatement
     */
    function convertFromPostgresArray(?string $value): ?array
    {
        if ($value === null) {
            return null;
        }
        $value = ltrim(rtrim($value, '}'), '{');
        if ($value === '') {
            return [];
        }

        $result = explode('",', $value);

        foreach ($result as $key => $item) {
            $result[$key] = rtrim(ltrim(stripcslashes($item), '"'), '"');

            if ($result[$key] === 'NULL') {
                $result[$key] = null;
            }
        }

        return $result;
    }

    if (!function_exists('getClass')) {
        /**
         * @param mixed $class
         *
         * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint.DisallowedMixedTypeHint
         */
        function getClass($class): string
        {
            if ($class === null) {
                return 'NULL';
            }

            if (!is_object($class)) {
                return 'Not object';
            }

            return get_class($class);
        }
    }
}
