<?php

namespace TeachersTrainingCenterBundle\Entity;

use TeachersTrainingCenterBundle\Entity\Traits\CreatedAtEntityTrait;
use TeachersTrainingCenterBundle\Entity\Traits\UpdatedAtEntityTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="`user`",
 *     options={"comment":"Stores data about user"}
 * )
 * @ORM\HasLifecycleCallbacks
 */
class User
{
    use CreatedAtEntityTrait;
    use UpdatedAtEntityTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=100, nullable=true, options={"comment":"User's name"})
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=100, nullable=true, options={"comment":"User's surname"})
     */
    private $surname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="avatar_url", type="string", nullable=true, options={"comment":"Url to user's avatar"})
     */
    private $avatarUrl;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true, length=6, options={"comment":"User's locale"})
     */
    private $locale;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true, options={"comment":"User's timezone"})
     */
    private $timezone;

    /**
     * @var ArrayCollection|TeacherStudent[]
     * @ORM\OneToMany(targetEntity="TeacherStudent", mappedBy="teacher")
     */
    private $teacherStudents;

    /**
     * @var ArrayCollection|TeacherStudent[]
     * @ORM\OneToMany(targetEntity="TeacherStudent", mappedBy="student")
     */
    private $studentTeachers;

    /**
     * @var ArrayCollection|Progress[]
     * @ORM\OneToMany(targetEntity="Progress", mappedBy="user")
     */
    private $userProgress;

    /**
     * @var ArrayCollection|StepProgress[]
     * @ORM\OneToMany(targetEntity="StepProgress", mappedBy="user")
     */
    private $userStepProgress;

    public function __construct()
    {
        $this->teacherStudents = new ArrayCollection();
        $this->studentTeachers = new ArrayCollection();
        $this->userProgress = new ArrayCollection();
        $this->userStepProgress = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }

    public function setAvatarUrl(?string $avatarUrl): self
    {
        $this->avatarUrl = $avatarUrl;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(?string $timezone): self
    {
        $this->timezone = $timezone;

        return $this;
    }

    public function setField(string $fieldName, $value): self
    {
        if (property_exists($this, $fieldName)) {
            $this->{$fieldName} = $value;
        }

        return $this;
    }
}
