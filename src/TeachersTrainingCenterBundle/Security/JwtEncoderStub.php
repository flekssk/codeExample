<?php

namespace TeachersTrainingCenterBundle\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

class JwtEncoderStub implements JWTEncoderInterface
{
    public function encode(array $data): string
    {
        return json_encode($data);
    }

    public function decode($token): array
    {
        return json_decode($token, true);
    }
}
