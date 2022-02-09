<?php

namespace TeachersTrainingCenterBundle\Controller\ServerApi\Access\v1\Input;

use TeachersTrainingCenterBundle\Entity\Traits\SafeLoadFieldsTrait;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints as Assert;

class AccessAction
{
    use SafeLoadFieldsTrait;

    /**
     * @SWG\Property(type="string", enum={"block.save", "block.list", "block.delete"})
     * @Assert\NotBlank()
     * @Assert\Choice(choices={"block.save", "block.list", "block.delete"})
     */
    private $action;

    /**
     * @SWG\Property(type="integer")
     * @Assert\NotBlank()
     * @Assert\Type(type="numeric")
     */
    private $userId;

    private $safeFields = ['action', 'userId'];

    public function getAction(): string
    {
        return $this->action;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
