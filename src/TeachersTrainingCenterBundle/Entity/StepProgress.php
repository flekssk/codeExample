<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use TeachersTrainingCenterBundle\Entity\Traits\CreatedAtEntityTrait;
use TeachersTrainingCenterBundle\Entity\Traits\UpdatedAtEntityTrait;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="`step_progress`",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="step_progress__user_id__step_id", columns={"user_id", "step_id"})
 *     },
 *     options={"comment":"Stores data about step score and progress"}
 * )
 * @ORM\HasLifecycleCallbacks
 */
class StepProgress
{
    use CreatedAtEntityTrait;
    use UpdatedAtEntityTrait;

    public const PROGRESS_TYPE_STEP = 'step';

    /**
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=40, nullable=false, options={"comment":"Step uuid"})
     */
    private string $stepId;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="userStepProgress")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    /**
     * @var string[]
     *
     * @ORM\Column(type="json", nullable=false, options={"jsonb": true, "comment":"Score, completeness"})
     */
    private array $value;

    public function getId(): int
    {
        return $this->id;
    }

    public function getStepId(): string
    {
        return $this->stepId;
    }

    public function setStepId(string $stepId): self
    {
        $this->stepId = $stepId;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getValue(): array
    {
        return $this->value;
    }

    /**
     * @param string[] $value
     */
    public function setValue(array $value): self
    {
        $this->value = $value;

        return $this;
    }
}
