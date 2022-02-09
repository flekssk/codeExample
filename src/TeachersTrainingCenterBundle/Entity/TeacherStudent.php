<?php

namespace TeachersTrainingCenterBundle\Entity;

use TeachersTrainingCenterBundle\Entity\Traits\CreatedAtEntityTrait;
use TeachersTrainingCenterBundle\Entity\Traits\UpdatedAtEntityTrait;
use TeachersTrainingCenterBundle\Entity\Traits\DeletedAtEntityTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="teacher_student",
 *     uniqueConstraints={@ORM\UniqueConstraint(columns={"teacher_id", "student_id"})})},
 *     options={"comment":"Lists teacher's students"}
 * )
 * @ORM\HasLifecycleCallbacks
 */
class TeacherStudent
{
    use CreatedAtEntityTrait;
    use UpdatedAtEntityTrait;
    use DeletedAtEntityTrait;

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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="teacherStudents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teacher;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="studentTeachers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    public function __construct()
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTeacher(): User
    {
        return $this->teacher;
    }

    public function setTeacher(User $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getStudent(): User
    {
        return $this->student;
    }

    public function setStudent(User $student): self
    {
        $this->student = $student;

        return $this;
    }
}
