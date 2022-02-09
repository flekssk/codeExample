<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\UserCourse\Model\Collection;

use TeachersTrainingCenterBundle\Feature\Content\Model\Collection\StructureCollection;
use TeachersTrainingCenterBundle\Feature\CourseAssignment\Model\Collection\CourseAssignmentContextCollection;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\DTO\UserCourseWithStructureDTO;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\Entity\UserCourse;

class UserCourseCollection implements \IteratorAggregate
{
    /**
     * @var UserCourse[]
     */
    private array $userCourses;

    public function __construct(UserCourse ...$userCourses)
    {
        $this->userCourses = $userCourses;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->userCourses);
    }

    /**
     * @param int[] $courseIds
     */
    public function diffByCourseIds(array $courseIds): self
    {
        $diff = array_filter(
            $this->userCourses,
            static fn(UserCourse $course) => !in_array($course->getCourseId(), $courseIds, true)
        );

        return new self(...$diff);
    }

    public function hasCourse(int $courseId): bool
    {
        $course = current(
            array_filter(
                $this->userCourses,
                static fn(UserCourse $userCourse) => $userCourse->getCourseId() === $courseId
            )
        );

        return (bool)$course;
    }

    public function filterByContexts(CourseAssignmentContextCollection $courseAssignmentContextCollection): self
    {
        $filter = static fn(UserCourse $userCourse): bool => $courseAssignmentContextCollection->hasContext(
            $userCourse->getAssignmentContextId()
        );

        return new self(
            ...array_filter(
                $this->userCourses,
                $filter
            )
        );
    }

    public function filterWithoutContext(): self
    {
        return new self(
            ...array_filter(
                $this->userCourses,
                static fn ($userCourse) => is_null($userCourse->getAssignmentContextId())
            )
        );
    }

    /**
     * @return int[]
     */
    public function getContextsIds(): array
    {
        return array_map(
            static fn($userCourse) => (int) $userCourse->getAssignmentContextId(),
            array_filter(
                $this->userCourses,
                static fn ($userCourse) => !is_null($userCourse->getAssignmentContextId())
            )
        );
    }

    /**
     * @return UserCourseWithStructureDTO[]
     */
    public function toCourseAssignmentDTOFilledByStructure(StructureCollection $structureCollection): array
    {
        $dto = [];

        foreach ($this->userCourses as $userCourse) {
            $course = $structureCollection->findCourse($userCourse->getCourseId());
            if (!is_null($course)) {
                $dto[] = new UserCourseWithStructureDTO(
                    $course->id,
                    $course->title,
                    $course->levels,
                    $userCourse->getDeadline()
                );
            }
        }

        return $dto;
    }

    /**
     * @return UserCourse[]
     */
    public function toArray(): array
    {
        return $this->userCourses;
    }

    public function isEmpty(): bool
    {
        return count($this->userCourses) === 0;
    }
}
