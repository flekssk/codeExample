<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Api\ContentApi;

use GuzzleHttp\Client;
use JsonMapper;
use JsonMapper_Exception;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use TeachersTrainingCenterBundle\Api\ContentApi\Model\Course;
use TeachersTrainingCenterBundle\Api\ContentApi\Model\Lesson;
use TeachersTrainingCenterBundle\Api\ContentApi\Model\LessonInfoWithPlan\LessonInfoWithPlan;

class ContentApi
{
    private const GET_LESSON_INFO_WITH_PLAN_CACHE_KEY = 'getLessonBaseInfoAndPlan%s';
    private const GET_LESSON_INFO_WITH_PLAN_CACHE_TTL = 3600;

    private const GET_LESSON_ACHIEVEMENTS_CACHE_KEY = 'getLessonAchievements%s';
    private const GET_LESSON_ACHIEVEMENTS_CACHE_TTL = 10;

    private const GET_PROGRAMS_WITH_LEVELS_CACHE_KEY = 'getProgramsWithLevelsTtc';
    private const GET_PROGRAMS_WITH_LEVELS_CACHE_TTL = 3600;

    private Client $contentApiClient;
    private JsonMapper $jsonMapper;
    private CacheInterface $cache;

    /**
     * @var string[]
     */
    private array $courseMap = [];

    public function __construct(Client $contentApiClient, JsonMapper $jsonMapper, CacheInterface $cache)
    {
        $this->contentApiClient = $contentApiClient;
        $this->jsonMapper = $jsonMapper;
        $this->cache = $cache;
    }

    /**
     * @return string[]
     */
    public function getCourseMap(): array
    {
        if ($this->courseMap !== []) {
            return $this->courseMap;
        }

        $allCourses = $this->getProgramsWithLevels();

        /** @var Course $course */
        foreach ($allCourses as $course) {
            $this->courseMap[$course->getId()] = $course->getTitle();
        }

        return $this->courseMap;
    }

    /**
     * @return array<int, Course>
     */
    public function getProgramsWithLevels(): array
    {
        $result = $this->cache->get(self::GET_PROGRAMS_WITH_LEVELS_CACHE_KEY, function (ItemInterface $item) {
            $item->expiresAfter(self::GET_PROGRAMS_WITH_LEVELS_CACHE_TTL);

            $response = $this->contentApiClient->get('/lesson/ajaxGetAllProgramsWithLevels/student/0')->getBody();

            return json_decode((string)$response);
        });

        return $this->jsonMapper->mapArray($result, [], Course::class);
    }

    public function getProgramWithLevels(int $id): ?Course
    {
        return $this->getProgramsWithLevels()[$id] ?? null;
    }

    /**
     * @return Lesson[]
     */
    public function getLessonsForCourseLevel(int $courseId, int $levelId): array
    {
        $response = $this->contentApiClient->get(
            "lesson/ajaxGetLessonsExtended/program/{$courseId}/level/{$levelId}"
            . '?withTotalStepsCount=1&withStepsTimeInMinutes=1',
        );

        return $this->jsonMapper->mapArray(json_decode((string)$response->getBody()), [], Lesson::class);
    }

    /**
     * @throws JsonMapper_Exception
     */
    public function getLessonInfoWithPlan(int $lessonId): LessonInfoWithPlan
    {
        $result = $this->cache->get(sprintf(self::GET_LESSON_INFO_WITH_PLAN_CACHE_KEY, $lessonId), function (
            ItemInterface $item
        ) use ($lessonId) {
            $item->expiresAfter(self::GET_LESSON_INFO_WITH_PLAN_CACHE_TTL);

            $response = $this->contentApiClient
                ->get('/serverApi/getLessonBaseInfoAndPlan', [
                    'query' => ['lessonId' => $lessonId],
                ])
                ->getBody();

            return json_decode((string)$response);
        });

        /** @var LessonInfoWithPlan $lessonInfo */
        $lessonInfo = $this->jsonMapper->map($result, new LessonInfoWithPlan());

        return $lessonInfo;
    }

    /**
     * @return ItemInterface[]
     */
    public function getLessonAchievements(int $lessonId): array
    {
        $result = $this->cache->get(sprintf(self::GET_LESSON_ACHIEVEMENTS_CACHE_KEY, $lessonId), function (
            ItemInterface $item
        ) use ($lessonId) {
            $item->expiresAfter(self::GET_LESSON_ACHIEVEMENTS_CACHE_TTL);

            $response = $this->contentApiClient
                ->get('/serverApi/getLessonAchievements', [
                    'query' => ['lessonId' => $lessonId],
                ])
                ->getBody();

            return json_decode((string)$response, true);
        });

        if (!is_array($result) || !isset($result['data'])) {
            return [];
        }

        return $result['data'];
    }

    public function getLevelTitle(int $levelId): string
    {
        /**
         * Маппинг из уровней CMS:
         * Starter -> Sky-Starter
         * Pre-Beginner -> Sky-Trainee
         * Beginner -> Sky-Junior
         * Elementary -> Sky-Middle
         * Pre-Intermediate -> Sky-Senior
         * Intermediate -> Sky-Master
         * Upper-Intermediate -> Sky-Expert
         *
         * Advanced и Proficiency - не используется
         */
        switch ($levelId) {
            case 8:
                return 'Sky-Starter';
            case 9:
                return 'Sky-Trainee';
            case 1:
                return 'Sky-Junior';
            case 2:
                return 'Sky-Middle';
            case 3:
                return 'Sky-Senior';
            case 4:
                return 'Sky-Master';
            case 5:
                return 'Sky-Expert';
            default:
                return 'Other';
        }
    }
}
