<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Collection;

use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Entity\CourseAssignmentContext;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\Collection\CourseGroupCollection;
use TeachersTrainingCenterBundle\Feature\CourseGroup\Model\Entity\CourseGroup;

class CourseAssignmentContextCollection implements \IteratorAggregate
{
    /**
     * @var CourseAssignmentContext[]
     */
    private array $elements;

    public function __construct(CourseAssignmentContext ...$contexts)
    {
        $this->elements = $contexts;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->elements);
    }

    public function hasContext(?int $id): bool
    {
        if (is_null($id)) {
            return false;
        }

        $context = array_filter($this->elements, static fn ($context) => $context->getId() === $id);

        return count($context) > 0;
    }

    public function getGroups(): CourseGroupCollection
    {
        $groups = [];

        foreach ($this->elements as $item) {
            if (!array_key_exists($item->getCourseGroup()->getId(), $groups)) {
                $groups[$item->getCourseGroup()->getId()] = $item->getCourseGroup();
            }
        }

        return new CourseGroupCollection(...$groups);
    }

    public function filterByGroup(CourseGroup $courseGroup): self
    {
        return new self(
            ...array_filter(
                $this->elements,
                static fn ($context) => $context->getCourseGroup()->getId() === $courseGroup->getId()
            )
        );
    }
}
