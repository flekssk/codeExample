<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use TeachersTrainingCenterBundle\Entity\Traits\CreatedAtEntityTrait;
use TeachersTrainingCenterBundle\Entity\Traits\UpdatedAtEntityTrait;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO\CourseAssignmentRulesCreateDTO;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO\CourseAssignmentRulesDTO;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\DTO\CourseAssignmentRulesUpdateDTO;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Enum\CourseAssignmentRulesTargetEnum;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\ValueObject\CourseAssignmentRulesId;

/**
 * @ORM\Entity()
 * @ORM\Table(name="course_assignment_rules")
 */
class CourseAssignmentRules
{
    use CreatedAtEntityTrait;
    use UpdatedAtEntityTrait;

    public const TABLE_NAME = 'course_assignment_rules';

    /**
     * @ORM\Column(type="bigint")
     * @ORM\Id
     * @phpcsSuppress SlevomatCodingStandard.Classes.UnusedPrivateElements.WriteOnlyProperty
     */
    private int $id;

    /**
     * @var string[]
     *
     * @ORM\Column(type="text[]", nullable=true)
     * @phpcsSuppress SlevomatCodingStandard.Classes.UnusedPrivateElements.WriteOnlyProperty
     */
    private array $rules;

    /**
     * @ORM\Column(type="course_assignment_rules_target")
     * @phpcsSuppress SlevomatCodingStandard.Classes.UnusedPrivateElements.WriteOnlyProperty
     */
    private CourseAssignmentRulesTargetEnum $target;

    /**
     * @param string[] $rules
     */
    public function __construct(CourseAssignmentRulesId $id, array $rules, CourseAssignmentRulesTargetEnum $target)
    {
        $this->id = $id->value;
        $this->rules = $rules;
        $this->target = $target;
        $this->refreshCreatedAt();
    }

    public static function fromCreateDTO(CourseAssignmentRulesId $id, CourseAssignmentRulesCreateDTO $dto): self
    {
        return new self($id, $dto->rules, $dto->target);
    }

    /**
     * @return string[]
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    public function getTarget(): CourseAssignmentRulesTargetEnum
    {
        return $this->target;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function toDto(): CourseAssignmentRulesDTO
    {
        return new CourseAssignmentRulesDTO($this->id, $this->rules);
    }

    public function update(CourseAssignmentRulesUpdateDTO $rules): self
    {
        $this->rules = $rules->rules;
        $this->target = $rules->target;

        $this->refreshUpdatedAt();

        return $this;
    }
}
