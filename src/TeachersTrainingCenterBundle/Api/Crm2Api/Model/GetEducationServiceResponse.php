<?php

namespace TeachersTrainingCenterBundle\Api\Crm2Api\Model;

use TeachersTrainingCenterBundle\Entity\Traits\SafeLoadFieldsTrait;
use Symfony\Component\Validator\Constraints as Assert;

class GetEducationServiceResponse
{
    use SafeLoadFieldsTrait;

    /** @var array */
    protected $safeFields = ['id', 'studentId', 'teacherId'];

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
     * @var int | null
     * @Assert\Type(type="numeric")
     */
    protected $teacherId;

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

    public function getTeacherId(): ?int
    {
        return (int) $this->teacherId;
    }
}
