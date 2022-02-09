<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Content\Step\v1;

use Psr\Log\LoggerInterface;
use Skyeng\VimboxCoreStepStore\API\Model\StepLoadRequest;
use Skyeng\VimboxCoreStepStore\API\Model\StepLoadResponse;
use Skyeng\VimboxCoreStepStore\API\ServerApiApi;

class StepManager
{
    /** @var ServerApiApi */
    private $apiClient;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(ServerApiApi $apiClient, LoggerInterface $logger)
    {
        $this->apiClient = $apiClient;
        $this->logger = $logger;
    }

    public function loadStep(int $studentId, string $stepUuid, bool $last): StepLoadResponse
    {
        $data = new StepLoadRequest([
            'studentId' => $studentId,
            'stepUuid' => $stepUuid,
            'last' => $last,
        ]);

        try {
            return $this->apiClient->v1StepLoadForUser($data);
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage(), ['StepManager::loadStep']);

            throw $e;
        }
    }
}
