<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Api\Trm\DTO\Response;

use JMS\Serializer\Annotation as JMS;

/** @psalm-immutable */
class FindTeacherIdsResponseDTO
{
    /**
     * @var int[]
     *
     * @JMS\Type("array<integer>")
     */
    public array $teacherIds = [];

    public bool $isLastPage = true;

    /**
     * @param int[] $teacherIds
     */
    public function __construct(array $teacherIds, bool $isLastPage)
    {
        $this->teacherIds = $teacherIds;
        $this->isLastPage = $isLastPage;
    }

    /**
     * @return int[]
     */
    public function getTeacherIds(): array
    {
        return $this->teacherIds;
    }

    public function isLastPage(): bool
    {
        return $this->isLastPage;
    }
}
