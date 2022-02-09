<?php

namespace TeachersTrainingCenterBundle\Controller\ServerApi\Access\v1\Output;

use Swagger\Annotations as SWG;

class StoreBlocksAuthorizationResponse
{
    /**
     * @SWG\Property(type="boolean")
     */
    public $isAllowed;

    public function __construct(bool $isAllowed)
    {
        $this->isAllowed = $isAllowed;
    }
}
