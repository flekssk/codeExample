<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\Feedback\v1;

use Psr\Log\LoggerInterface;
use Skyeng\VimboxFeedback\API\Model\SetAnswerRequestDTO;
use Skyeng\VimboxFeedback\API\SetAnswerApi;

class FeedbackManager
{
    /** @var SetAnswerApi */
    private $apiClient;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(SetAnswerApi $apiClient, LoggerInterface $logger)
    {
        $this->apiClient = $apiClient;
        $this->logger = $logger;
    }

    public function setAnswer(
        string $questionAlias,
        string $periodId,
        int $userId,
        ?int $answerMark,
        ?string $answerComment,
        ?array $payload
    ): void {
        $data = new SetAnswerRequestDTO([
            'questionAlias' => $questionAlias,
            'periodId' => $periodId,
            'userId' => $userId,
            'answerMark' => $answerMark,
            'answerComment' => $answerComment,
            'payload' => $payload,
        ]);

        try {
            $this->apiClient->v1SetAnswer($data);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), ['FeedbackManager::setAnswer']);

            throw $e;
        }
    }
}
