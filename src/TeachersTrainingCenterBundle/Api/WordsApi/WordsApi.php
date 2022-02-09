<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Api\WordsApi;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Log\LoggerInterface;
use TeachersTrainingCenterBundle\Api\ContentApi\Model\LessonInfoWithPlan\LessonInfo;

class WordsApi
{
    private const SOURCE_TYPE_LESSON = 'lesson';

    private Client $client;

    private LoggerInterface $logger;

    public function __construct(Client $client, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    /**
     * @return string[]
     */
    public function createWordset(int $studentId, int $lessonId, LessonInfo $lessonInfo): array
    {
        $url = '/api/internal/for-vimbox/v2/wordsets/find-or-create.json';

        $requestBody = [
            RequestOptions::JSON => [
                'wordset' => [
                    'title' => $lessonInfo->getTitle(),
                    'subtitle' => $lessonInfo->getProgram(),
                    'imageUrl' => $lessonInfo->getImageUrl(),
                    'source' => 'vclass',
                    'sourceSet' => [
                        'id' => $lessonId,
                        'type' => self::SOURCE_TYPE_LESSON,
                    ],
                ],
                'studentId' => $studentId,
            ],
        ];

        $this->logger->info("WordsAPI: sending createWordset to $url\nRequest body:\n", $requestBody);

        $response = $this->client->put($url, $requestBody);

        $responseBody = json_decode((string)$response->getBody(), true);

        $this->logger->info(
            "WordsAPI: response received, HTTP status: {$response->getStatusCode()}\nResponse body:\n",
            (array)$responseBody,
        );

        return $responseBody;
    }
}
