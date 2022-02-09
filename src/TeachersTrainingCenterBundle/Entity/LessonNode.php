<?php

namespace TeachersTrainingCenterBundle\Entity;

use TeachersTrainingCenterBundle\Entity\Traits\CreatedAtEntityTrait;
use TeachersTrainingCenterBundle\Entity\Traits\UpdatedAtEntityTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="`lesson_node`",
 *     options={"comment":"Data about user lessons"},
 *     indexes={@ORM\Index(name="student_lesson_idx", columns={"student_id", "lesson_id"})}
 * )
 * @ORM\HasLifecycleCallbacks
 */
class LessonNode
{
    use CreatedAtEntityTrait;
    use UpdatedAtEntityTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    /**
     * @var int
     *
     * @ORM\Column(type="bigint", nullable=false, options={"comment":"Structure lesson id"})
     */
    private $lessonId;

    /**
     * @var int
     *
     * @ORM\Column(type="bigint", nullable=false, options={"comment":"Rooms node id"})
     */
    private $nodeId;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return User
     */
    public function getStudent(): User
    {
        return $this->student;
    }

    /**
     * @param User $student
     */
    public function setStudent(User $student): self
    {
        $this->student = $student;
        return $this;
    }

    /**
     * @return int
     */
    public function getLessonId(): int
    {
        return $this->lessonId;
    }

    /**
     * @param int $lessonId
     */
    public function setLessonId(int $lessonId): self
    {
        $this->lessonId = $lessonId;
        return $this;
    }

    /**
     * @return int
     */
    public function getNodeId(): int
    {
        return $this->nodeId;
    }

    /**
     * @param int $nodeId
     */
    public function setNodeId(int $nodeId): self
    {
        $this->nodeId = $nodeId;
        return $this;
    }
}
