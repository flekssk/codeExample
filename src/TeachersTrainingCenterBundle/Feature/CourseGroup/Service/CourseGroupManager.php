<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Service;

use TeachersCommonBundle\Feature\ConventionalResponse\Exception\EntityNotFoundConventionalException;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\DAO\CourseGroupDAO;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\DTO\CourseGroupCreateDTO;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\DTO\CourseGroupDTO;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\DTO\CourseGroupUpdateDTO;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\Entity\CourseGroup;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\ValueObject\CourseGroupId;

class CourseGroupManager
{
    private CourseGroupDAO $courseGroupDAO;

    public function __construct(CourseGroupDAO $courseGroupDAO)
    {
        $this->courseGroupDAO = $courseGroupDAO;
    }

    /**
     * @param int[] $ids
     *
     * @return CourseGroupDTO[]
     */
    public function findByIds(array $ids): array
    {
        $collection = $this->courseGroupDAO->findByIds($ids);
        $courseGroupDTOs = [];

        foreach ($collection as $courseGroup) {
            $courseGroupDTOs[] = $courseGroup->toDto();
        }

        return $courseGroupDTOs;
    }

    /**
     * @param int[] $ids
     *
     * @return CourseGroupDTO[]
     */
    public function findByIdsWithAssignment(array $ids): array
    {
        $collection = $this->courseGroupDAO->findByIds($ids);
        $courseGroupDTOs = [];

        foreach ($collection as $courseGroup) {
            $courseGroupDTOs[] = $courseGroup->toDto();
        }

        return $courseGroupDTOs;
    }

    /**
     * @return CourseGroupDTO[]
     *
     * @psalm-param array<string, string>|null $orderBy
     */
    public function findAll(?array $orderBy = null): array
    {
        $DTOs = [];
        $courseGroups = $this->courseGroupDAO->findAll($orderBy);

        foreach ($courseGroups->toArray() as $courseGroup) {
            $DTOs[] = $courseGroup->toDto();
        }

        return $DTOs;
    }

    public function create(CourseGroupCreateDTO $dto): CourseGroupDTO
    {
        return $this->courseGroupDAO->create($dto)->toDto();
    }

    public function update(CourseGroupUpdateDTO $dto): CourseGroupDTO
    {
        $courseGroup = $this->courseGroupDAO->find(new CourseGroupId($dto->id));

        if (is_null($courseGroup)) {
            throw new EntityNotFoundConventionalException($dto->id, CourseGroup::class);
        }

        $courseGroup->update($dto);

        $this->courseGroupDAO->save($courseGroup);

        return $courseGroup->toDto();
    }
}
