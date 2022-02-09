<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\UserCourse\Model\DTO;

use TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output\Model\Level;

class UserCourseWithStructureDTO
{
    public int $courseId;

    public string $title;

    /**
     * @var Level[]
     */
    public array $structure;

    public ?\DateTimeImmutable $deadline;

    /**
     * @param Level[] $structure
     */
    public function __construct(int $courseId, string $title, array $structure, ?\DateTimeImmutable $deadline)
    {
        $this->courseId = $courseId;
        $this->title = $title;
        $this->structure = $structure;
        $this->deadline = $deadline;
    }
}
