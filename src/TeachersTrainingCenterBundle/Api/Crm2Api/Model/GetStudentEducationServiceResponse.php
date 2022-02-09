<?php

namespace TeachersTrainingCenterBundle\Api\Crm2Api\Model;

use TeachersTrainingCenterBundle\Entity\Traits\SafeLoadFieldsTrait;
use Symfony\Component\Validator\Constraints as Assert;

class GetStudentEducationServiceResponse
{
    use SafeLoadFieldsTrait;

    /** @var array */
    protected $safeFields = ['id', 'studentId'];

    /**
     * @var int
     * @Assert\NotBlank()
     * @Assert\Type(type="numeric")
     */
    protected $id;

    /**
     * @var int
     * @Assert\NotBlank()
     * @Assert\Type(type="numeric")
     */
    protected $studentId;

    /**
     * Returns educationServiceId
     */
    public function getId(): int
    {
        return (int) $this->id;
    }

    public function getStudentId(): int
    {
        return (int) $this->studentId;
    }
}
