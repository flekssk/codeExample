<?php

namespace TeachersTrainingCenterBundle\Controller\Api\User\Progress\v1;

use TeachersTrainingCenterBundle\Controller\Api\User\Progress\v1\Input\PostProgressRequest;
use TeachersTrainingCenterBundle\Entity\Progress;
use TeachersTrainingCenterBundle\Entity\StepProgress;
use TeachersTrainingCenterBundle\Entity\User;
use TeachersTrainingCenterBundle\Repository\ProgressRepository;
use TeachersTrainingCenterBundle\Repository\StepProgressRepository;
use TeachersTrainingCenterBundle\Repository\UserRepository;
use Skyeng\VimboxCoreRooms\API\Model\NodeSetStepScoreRequest;
use Skyeng\VimboxCoreRooms\API\NodeApi;

class ProgressManager
{
    /** @var ProgressRepository */
    private $progressRepository;

    /** @var StepProgressRepository */
    private $stepProgressRepository;

    /** @var UserRepository */
    private $userRepository;

    /** @var NodeApi */
    private $nodeApi;

    public function __construct(
        ProgressRepository $progressRepository,
        StepProgressRepository $stepProgressRepository,
        UserRepository $userRepository,
        NodeApi $nodeApi
    ) {
        $this->progressRepository = $progressRepository;
        $this->stepProgressRepository = $stepProgressRepository;
        $this->userRepository = $userRepository;
        $this->nodeApi = $nodeApi;
    }

    /**
     * @param int $userId
     * @return Progress[]
     */
    public function getForCourseAndLessonByUserId(int $userId): array
    {
        return $this->progressRepository->getForCourseAndLessonByUserId($userId);
    }

    public function updateProgressFromRequest(PostProgressRequest $request, int $userId): void
    {
        $user = $this->userRepository->find($userId);
        if (empty($user)) {
            throw new \UnexpectedValueException("User {$userId} was not found");
        }

        $value = [
            'score' => $request->getScore(),
            'completeness' => $request->getCompleteness(),
        ];
        if ($request->getProgressType() === StepProgress::PROGRESS_TYPE_STEP) {
            $this->updateStepProgress($request->getProgressId(), $user, $value);
            $this->nodeApi->v1NodeSetStepScore(
                new NodeSetStepScoreRequest([
                    'stepId' => $request->getProgressId(),
                    'identityId' => $user->getId(),
                    'identityType' => NodeSetStepScoreRequest::IDENTITY_TYPE_USER_ID,
                    'score' => $request->getScore(),
                    'completeness' => $request->getCompleteness(),
                    'updatedAt' => new \DateTime(),
                ]),
            );
        } else {
            $this->updateProgress($request->getProgressId(), $request->getProgressType(), $user, $value);
        }
    }

    public function updateProgress(string $progressId, string $progressType, User $user, array $value): void
    {
        $progress = $this->progressRepository->findOneBy([
            'user' => $user,
            'progressId' => $progressId,
            'progressType' => $progressType,
        ]);
        if (empty($progress)) {
            $this->progressRepository->create($progressId, $progressType, $user, $value);
        } else {
            $this->progressRepository->updateValue($progress, $value);
        }
    }

    public function updateStepProgress(string $stepId, User $user, array $value): void
    {
        $stepProgress = $this->stepProgressRepository->findOneBy([
            'user' => $user,
            'stepId' => $stepId,
        ]);
        if (empty($stepProgress)) {
            $this->stepProgressRepository->create($stepId, $user, $value);
        } else {
            $this->stepProgressRepository->updateValue($stepProgress, $value);
        }
    }
}
