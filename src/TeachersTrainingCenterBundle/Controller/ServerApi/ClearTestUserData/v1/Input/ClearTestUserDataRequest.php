<?php

namespace TeachersTrainingCenterBundle\Controller\ServerApi\ClearTestUserData\v1\Input;

use TeachersTrainingCenterBundle\Entity\Traits\SafeLoadFieldsTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

class ClearTestUserDataRequest
{
    use SafeLoadFieldsTrait;

    /**
     * @var int
     * @Assert\Type("numeric")
     * @Assert\GreaterThan(0)
     * @SWG\Property(type="integer", example=123)
     */
    public $userId;

    private $safeFields = ['userId'];
}
