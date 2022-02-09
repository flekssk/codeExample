<?php

namespace TeachersTrainingCenterBundle\Controller\ServerApi\Access\v1\Input;

use TeachersTrainingCenterBundle\Entity\Traits\SafeLoadFieldsTrait;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;

class AccessUser
{
    use SafeLoadFieldsTrait;

    /**
     * @SWG\Property(type="integer")
     * @Assert\NotBlank()
     * @Assert\Type(type="numeric")
     */
    private $id;

    /**
     * @SWG\Property(type="array", @SWG\Items(type="string"))
     */
    private $roles;

    private $safeFields = ['id', 'roles'];

    public function getId(): int
    {
        return $this->id;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
}
