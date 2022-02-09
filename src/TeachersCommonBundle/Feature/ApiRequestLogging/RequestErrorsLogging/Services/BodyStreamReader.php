<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ApiRequestLogging\RequestErrorsLogging\Services;

use Psr\Http\Message\StreamInterface;

class BodyStreamReader
{
    public const MAX_BODY_SIZE = 1024 * 5;

    public static function readBodyForLogging(StreamInterface $body): ?string
    {
        if (!$body->isSeekable()) {
            return null;
        }

        $size = $body->getSize();

        if ($size === 0) {
            return null;
        }

        $body->rewind();
        $bodyTruncated = $body->read(self::MAX_BODY_SIZE);
        $body->rewind();

        if ($size > self::MAX_BODY_SIZE) {
            $bodyTruncated .= ' (truncated...)';
        }

        // Matches any printable character, including unicode characters:
        // letters, marks, numbers, punctuation, spacing, and separators.
        if (preg_match('/[^\pL\pM\pN\pP\pS\pZ\n\r\t]/', $bodyTruncated)) {
            return '...(truncated. Malformed UTF-8 characters)...';
        }

        return $bodyTruncated;
    }
}
