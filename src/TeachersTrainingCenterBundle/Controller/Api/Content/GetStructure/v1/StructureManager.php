<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use TeachersTrainingCenterBundle\Api\ContentApi\ContentApi;
use TeachersTrainingCenterBundle\Api\ContentApi\Model\Course as ContentCourse;
use TeachersTrainingCenterBundle\Api\ContentApi\Model\Lesson as ContentLesson;
use TeachersTrainingCenterBundle\Api\ContentApi\Model\Level as ContentLevel;
use TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output\Model\Course;
use TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output\Model\Group;
use TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output\Model\Lesson;
use TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output\Model\Level;
use TeachersTrainingCenterBundle\Service\UserCourseService;

class StructureManager
{
    private const CACHED_STRUCTURE_KEY = 'cached_lesson_structure_%s';
    private const CACHE_LIFETIME = 24 * 3600;

    private ContentApi $contentApi;

    private CacheInterface $cache;

    private UserCourseService $userCourseService;

    public function __construct(ContentApi $contentApi, CacheInterface $cache, UserCourseService $userCourseService)
    {
        $this->contentApi = $contentApi;
        $this->cache = $cache;
        $this->userCourseService = $userCourseService;
    }

    /**
     * @return Group[]
     */
    public function getStructure(?int $userId = null): array
    {
        $allAvailableCourseIds = $this->userCourseService->getAllAvailableCourseIds();
        $allCourses = $this->contentApi->getProgramsWithLevels();

        if ($userId === null) {
            $cacheKey = sprintf(self::CACHED_STRUCTURE_KEY, md5(implode(',', $allAvailableCourseIds)));

            return $this->cache->get($cacheKey, function (ItemInterface $item) use ($allCourses) {
                $item->expiresAfter(self::CACHE_LIFETIME);

                return $this->loadStructure($allCourses);
            });
        }

        $courseIdsForUser = $this->userCourseService->getAllowedCourseIdsForUser($userId);

        $cacheKey = sprintf(self::CACHED_STRUCTURE_KEY, md5(implode(',', $courseIdsForUser)));

        return $this->cache->get($cacheKey, function (ItemInterface $item) use ($allCourses, $userId) {
            $item->expiresAfter(self::CACHE_LIFETIME);

            return $this->loadStructure($allCourses, $userId);
        });
    }

    /**
     * @param ContentCourse[] $allCourses
     *
     * @return Group[]
     */
    private function loadStructure(array $allCourses, ?int $userId = null): array
    {
        $contentCourses = $this->filterAllowedCourses($allCourses, $userId);

        $result = [];
        /** @var ContentCourse $contentCourse */
        foreach ($contentCourses as $contentCourse) {
            if ($contentCourse->getGroup() === null) {
                if (!isset($result[-1])) {
                    $group = new Group();
                    $group->id = -1;
                    $group->title = 'No Group';

                    $result[$group->id] = $group;
                } else {
                    $group = $result[-1];
                }
            } elseif (!isset($result[$contentCourse->getGroup()->id])) {
                $group = new Group();
                $group->id = $contentCourse->getGroup()->id;
                $group->title = $contentCourse->getGroup()->title;

                $result[$group->id] = $group;
            } else {
                $group = $result[$contentCourse->getGroup()->id];
            }

            $group->courses[] = $this->processCourse($contentCourse);
        }

        return array_values($result);
    }

    /**
     * @param ContentCourse[] $structure
     *
     * @return ContentCourse[]
     */
    private function filterAllowedCourses(array $structure, ?int $userId = null): array
    {
        $allowedCourseIds =
            $userId === null
                ? $this->userCourseService->getAllAvailableCourseIds()
                : $this->userCourseService->getAllowedCourseIdsForUser($userId);

        $allowedCourses = [];

        foreach ($structure as $course) {
            if (in_array($course->getId(), $allowedCourseIds, true)) {
                $allowedCourses[] = $course;
            }
        }

        return $allowedCourses;
    }

    private function processCourse(ContentCourse $contentCourse): Course
    {
        $course = new Course();
        $course->id = $contentCourse->getId();
        $course->title = $contentCourse->getTitle();

        foreach ($contentCourse->getLevels() as $contentLevel) {
            $course->levels[] = $this->processlevel($contentLevel, $course->id);
        }

        return $course;
    }

    private function processlevel(ContentLevel $contentLevel, int $courseId): Level
    {
        $level = new Level();
        $level->id = $contentLevel->getId();
        $level->title = $this->contentApi->getLevelTitle($level->id);
        $level->lessons = $this->loadLessons($courseId, $level->id);

        return $level;
    }

    /**
     * @return Lesson[]
     */
    private function loadLessons(int $courseId, int $levelId): array
    {
        $contentLessons = $this->contentApi->getLessonsForCourseLevel($courseId, $levelId);
        $lessons = [];
        foreach ($contentLessons as $contentLesson) {
            $lessons[] = $this->processLesson($contentLesson);
        }

        return $lessons;
    }

    private function processLesson(ContentLesson $contentLesson): Lesson
    {
        $lesson = new Lesson();
        $lesson->id = $contentLesson->getId();
        $lesson->title = $contentLesson->getTitle();
        $lesson->section = $contentLesson->getSection();
        $lesson->stepsCount = $contentLesson->getStepsCount();
        $lesson->stepsTimeInMinutes = $contentLesson->getStepsTimeInMinutes();

        return $lesson;
    }
}
