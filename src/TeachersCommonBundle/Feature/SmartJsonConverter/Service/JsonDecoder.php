<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\SmartJsonConverter\Service;

class JsonDecoder
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingAnyTypeHint
     * @throws \Exception
     */
    public function decodeJson(string $str)
    {
        $decoded = json_decode($str);
        $errorMessage = 'Could not decode JSON in request body';

        switch (json_last_error()) {
            case \JSON_ERROR_NONE:
                return $decoded;
            case \JSON_ERROR_DEPTH:
                throw new \Exception($errorMessage . ': maximum stack depth exceeded');
            case \JSON_ERROR_STATE_MISMATCH:
                throw new \Exception($errorMessage . ': underflow or the nodes mismatch');
            case \JSON_ERROR_CTRL_CHAR:
                throw new \Exception($errorMessage . ': unexpected control character found');
            case \JSON_ERROR_SYNTAX:
                throw new \Exception($errorMessage . ': syntax error - malformed JSON');
            case \JSON_ERROR_UTF8:
                throw new \Exception($errorMessage . ': malformed UTF-8 characters (incorrectly encoded?)');
            default:
                throw new \Exception($errorMessage);
        }
    }
}
