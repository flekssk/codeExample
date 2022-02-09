<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseGroup\Model\Collection;

use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\Entity\CourseGroup;

class CourseGroupCollection implements \IteratorAggregate
{
    /**
     * @var CourseGroup[]
     */
    private array $elements;

    public function __construct(CourseGroup ...$courseGroups)
    {
        $this->elements = $courseGroups;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->elements);
    }

    /**
     * @return CourseGroup[]
     */
    public function toArray(): array
    {
        return $this->elements;
    }
}
