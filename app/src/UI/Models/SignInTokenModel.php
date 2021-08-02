<?php

namespace App\UI\Models;

use Swagger\Annotations as SWG;

/**
 * Class SignInTokenValidationModel
 * @package App\UI\Form
 *
 * @SWG\Definition(
 *     required={"token"}
 * )
 */
class SignInTokenModel
{
    /**
     * Токен ID2
     * @var string
     */
    protected $token = '';

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken($token): self
    {
        $this->token = $token;

        return $this;
    }
}
