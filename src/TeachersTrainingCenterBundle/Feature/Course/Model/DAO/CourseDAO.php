<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\Course\Model\DAO;

use TeachersTrainingCenterBundle\Api\ContentApi\ContentApi;
use TeachersTrainingCenterBundle\Api\ContentApi\Model\Course;
use TeachersTrainingCenterBundle\Feature\Course\Model\Collection\CourseCollection;

class CourseDAO
{
    private ContentApi $contentApi;

    public function __construct(ContentApi $contentApi)
    {
        $this->contentApi = $contentApi;
    }

    public function findAll(): CourseCollection
    {
        return new CourseCollection(...$this->contentApi->getProgramsWithLevels());
    }

    public function find(int $id): ?Course
    {
        return $this->contentApi->getProgramWithLevels($id);
    }

    /**
     * @param int[] $ids
     */
    public function findByIds(array $ids): CourseCollection
    {
        return $this->findAll()->getIntersection($ids);
    }
}
