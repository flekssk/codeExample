<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\SmartJsonConverter\DTO;

/**
 * Маркерный интерфейс, благодаря которому мы понимаем, какой param converter нужно использовать
 */
interface SmartJsonRequestDTO
{
    public static function relativeSchemaPath(): string;
}
