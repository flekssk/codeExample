<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiResponseLogging\Service;

class RequestOriginBeautifier
{
    private const UNKNOWN = 'UNKNOWN';

    private string $baseDomain;

    public function __construct(string $baseDomain = 'skyeng.ru')
    {
        $this->baseDomain = $baseDomain;
    }

    public function beautify(?string $origin): string
    {
        if (!is_string($origin) || $origin === '') {
            return self::UNKNOWN;
        }

        $origin = preg_replace(
            ['/^https?:\/\//', '/:\d+$/', sprintf('/\.%s$/', preg_quote($this->baseDomain, '/'))],
            ['', '', ''],
            $origin
        );

        return $this->escape($origin);
    }

    private function escape(string $str): string
    {
        return str_replace('.', '_', $str);
    }
}
