<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\VideoConfig\v1\Input;

use TeachersTrainingCenterBundle\Entity\Traits\SafeLoadFieldsTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

final class VideoConfigRequest
{
    use SafeLoadFieldsTrait;

    /**
     * @SWG\Property(type="string")
     * @Assert\NotNull()
     */
    public $roomHash;

    private $safeFields = ['roomHash'];
}
