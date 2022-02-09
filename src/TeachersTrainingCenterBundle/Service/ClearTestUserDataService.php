<?php

namespace TeachersTrainingCenterBundle\Service;

use TeachersTrainingCenterBundle\ErrorHandling\Exceptions\EntityNotFoundException;
use TeachersTrainingCenterBundle\Repository\ProgressRepository;
use TeachersTrainingCenterBundle\Repository\StepProgressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Skyeng\VimboxCoreRooms\API\ComplexApi;
use Skyeng\VimboxCoreRooms\API\Model\ClearTestUserDataRequest;

class ClearTestUserDataService
{
    private const IDENTITY_TYPE = 'userId';

    /** @var string[] */
    private $testUsers;
    /** @var string */
    private $scope;
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var ComplexApi */
    private $complexApi;
    /** @var ProgressRepository */
    private $progressRepository;
    /** @var StepProgressRepository */
    private $stepProgressRepository;

    public function __construct(
        array $testUsers,
        string $scope,
        EntityManagerInterface $entityManager,
        ComplexApi $complexApi,
        ProgressRepository $progressRepository,
        StepProgressRepository $stepProgressRepository
    ) {
        $this->testUsers = $testUsers;
        $this->scope = $scope;
        $this->entityManager = $entityManager;
        $this->complexApi = $complexApi;
        $this->progressRepository = $progressRepository;
        $this->stepProgressRepository = $stepProgressRepository;
    }

    public function clearTestUserData(int $userId): void
    {
        if (!$this->isValidTestUser($userId)) {
            throw new EntityNotFoundException(sprintf('Test user %d not found', $userId));
        }
        $payload = new ClearTestUserDataRequest();
        $payload->setIdentityType(self::IDENTITY_TYPE);
        $payload->setIdentityId($userId);
        $payload->setScope($this->scope);
        $this->complexApi->complexV1ClearTestUserData($payload);
    }

    public function clearTestUserDataWithProgress(int $userId): void
    {
        $this->clearTestUserData($userId);
        $progresses = $this->progressRepository->findBy(['user' => $userId]);
        foreach ($progresses as $progress) {
            $this->entityManager->remove($progress);
        }
        $stepProgresses = $this->stepProgressRepository->findBy(['user' => $userId]);
        foreach ($stepProgresses as $stepProgress) {
            $this->entityManager->remove($stepProgress);
        }
        $this->entityManager->flush();
    }

    private function isValidTestUser(int $userId): bool
    {
        return in_array($userId, $this->testUsers, true);
    }
}
