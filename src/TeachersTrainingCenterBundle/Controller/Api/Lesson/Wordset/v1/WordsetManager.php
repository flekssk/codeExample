<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\Wordset\v1;

use TeachersTrainingCenterBundle\Api\ContentApi\ContentApi;
use TeachersTrainingCenterBundle\Api\WordsApi\WordsApi;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class WordsetManager
{
    private const STUDENT_LESSON_WORDSET_CACHE_KEY = 'studentId-%s-lessonId-%s';
    private const STUDENT_LESSON_WORDSET_CACHE_TTL = 3600; // 1 hour

    /**
     * @var ContentApi
     */
    private $contentApi;

    /**
     * @var WordsApi
     */
    private $wordsApi;

    /**
     * @var CacheInterface
     */
    private $cache;

    public function __construct(ContentApi $contentApi, WordsApi $wordsApi, CacheInterface $cache)
    {
        $this->contentApi = $contentApi;
        $this->wordsApi = $wordsApi;
        $this->cache = $cache;
    }

    public function ensureWordsetId(int $studentId, int $lessonId): int
    {
        $cacheKey = sprintf(self::STUDENT_LESSON_WORDSET_CACHE_KEY, $studentId, $lessonId);

        $wordsetId = $this->cache->get($cacheKey, function (ItemInterface $item) use ($studentId, $lessonId) {
            $item->expiresAfter(self::STUDENT_LESSON_WORDSET_CACHE_TTL);

            $lessonInfo = $this->contentApi->getLessonInfoWithPlan($lessonId)->getLessonInfo();
            $wordsetFromResponse = $this->wordsApi->createWordset($studentId, $lessonId, $lessonInfo);

            return $wordsetFromResponse['id'];
        });

        return $wordsetId;
    }
}
