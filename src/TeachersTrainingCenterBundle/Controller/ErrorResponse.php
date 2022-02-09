<?php

namespace TeachersTrainingCenterBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

class ErrorResponse
{
    /**
     * @SWG\Property(type="boolean", default=false)
     */
    public $success = false;

    /**
     * @SWG\Property(type="array", @Model(type=Error::class))
     */
    public $errors;

    public function __construct(Error ...$errors)
    {
        $this->errors = $errors;
    }
}
