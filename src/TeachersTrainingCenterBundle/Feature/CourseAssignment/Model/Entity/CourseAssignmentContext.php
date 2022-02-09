<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use TeachersTrainingCenterBundle\Entity\Traits\CreatedAtEntityTrait;
use TeachersTrainingCenterBundle\Entity\Traits\UpdatedAtEntityTrait;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO\CourseAssignmentContextDTO;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\ValueObject\CourseAssignmentContextId;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\Entity\CourseGroup;

/**
 * @ORM\Entity()
 * @ORM\Table(name="course_assignment_context")
 */
class CourseAssignmentContext
{
    use CreatedAtEntityTrait;
    use UpdatedAtEntityTrait;

    /**
     * @ORM\Column(type="bigint")
     * @ORM\Id
     * @phpcsSuppress SlevomatCodingStandard.Classes.UnusedPrivateElements.WriteOnlyProperty
     */
    private int $id;

    /**
     * @ORM\JoinColumn(referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="TeachersTrainingCenterBundle\Feature\CourseGroup\Model\Entity\CourseGroup")
     * @phpcsSuppress SlevomatCodingStandard.Classes.UnusedPrivateElements.WriteOnlyProperty
     */
    private CourseGroup $courseGroup;

    /**
     * @ORM\JoinColumn(referencedColumnName="id")
     * @ORM\ManyToOne(targetEntity="CourseAssignmentRules")
     * @phpcsSuppress SlevomatCodingStandard.Classes.UnusedPrivateElements.WriteOnlyProperty
     */
    private CourseAssignmentRules $rules;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @phpcsSuppress SlevomatCodingStandard.Classes.UnusedPrivateElements.WriteOnlyProperty
     */
    private ?int $deadlineInDays;

    public function __construct(
        CourseAssignmentContextId $id,
        CourseGroup $courseGroup,
        CourseAssignmentRules $rules,
        ?int $deadlineInDays = null
    ) {
        $this->id = $id->value;
        $this->courseGroup = $courseGroup;
        $this->rules = $rules;
        $this->deadlineInDays = $deadlineInDays;
        $this->refreshCreatedAt();
    }

    /**
     * @return CourseGroup
     */
    public function getCourseGroup(): CourseGroup
    {
        return $this->courseGroup;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function calculateDeadlineDateFromNow(): ?\DateTimeImmutable
    {
        $deadlineDate = null;

        if (!is_null($this->deadlineInDays)) {
            $deadlineDate = (new \DateTimeImmutable())
                ->add(new \DateInterval("P{$this->deadlineInDays}D"));
        }

        return $deadlineDate;
    }

    public function getRules(): CourseAssignmentRules
    {
        return $this->rules;
    }

    public function toDto(): CourseAssignmentContextDTO
    {
        return new CourseAssignmentContextDTO(
            $this->id,
            $this->courseGroup->toDto(),
            $this->rules->toDto(),
            $this->deadlineInDays
        );
    }

    public function setRules(CourseAssignmentRules $rules): void
    {
        $this->rules = $rules;
    }

    public function setDeadlineInDays(?int $deadlineInDays): void
    {
        $this->deadlineInDays = $deadlineInDays;
    }
}
