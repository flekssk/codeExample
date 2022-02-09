<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\Course\Model\Collection;

use TeachersTrainingCenterBundle\Api\ContentApi\Model\Course;

class CourseCollection implements \IteratorAggregate
{
    /**
     * @var Course[]
     */
    private array $elements;

    public function __construct(Course ...$elements)
    {
        $this->elements = $elements;
    }

    /**
     * @param int[] $ids
     */
    public function getIntersection(array $ids): self
    {
        return new self(
            ...array_filter($this->elements, static fn (Course $course) => in_array($course->getId(), $ids, true))
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->elements);
    }
}
