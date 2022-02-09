<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Controller\ServerApi\User\Progress;

use Doctrine\ORM\EntityManagerInterface;
use TeachersTrainingCenterBundle\Controller\ServerApi\User\Progress\Input\PostProgressBatchRequest;
use TeachersTrainingCenterBundle\Controller\ServerApi\User\Progress\Input\ProgressItem;
use TeachersTrainingCenterBundle\Entity\Progress;
use TeachersTrainingCenterBundle\Entity\StepProgress;
use TeachersTrainingCenterBundle\Service\UserService;

class ProgressManager
{
    private EntityManagerInterface $entityManager;

    private UserService $userService;

    public function __construct(EntityManagerInterface $entityManager, UserService $userService)
    {
        $this->entityManager = $entityManager;
        $this->userService = $userService;
    }

    public function updateProgressFromRequest(PostProgressBatchRequest $request): void
    {
        $userId = $request->getUserId();
        $users = $this->userService->ensureUsersExistByIds([$userId]);
        $user = array_shift($users);

        $stepProgressItems = [];
        $courseProgressItems = [];
        foreach ($request->getItems() as $progressItem) {
            if ($progressItem->getProgressType() === StepProgress::PROGRESS_TYPE_STEP) {
                $stepProgressItems[] = $progressItem;
            } elseif (in_array($progressItem->getProgressType(), Progress::PROGRESS_TYPES, true)) {
                $courseProgressItems[] = $progressItem;
            }
        }

        if (count($courseProgressItems) > 0) {
            $qb = $this->entityManager->createQueryBuilder();
            /** @var Progress[] $existProgress */
            $existProgress = $qb
                ->select('p')
                ->from(Progress::class, 'p', 'p.progressId')
                ->andWhere($qb->expr()->eq('p.user', ':user'))
                ->andWhere($qb->expr()->in('p.progressId', ':progressIds'))
                ->andWhere($qb->expr()->in('p.progressType', ':progressTypes'))
                ->setParameter('user', $user->getId())
                ->setParameter(
                    'progressIds',
                    array_map(
                        static fn (ProgressItem $progress) => $progress->getProgressId(),
                        $courseProgressItems
                    ),
                )
                ->setParameter(
                    'progressTypes',
                    array_map(
                        static fn (ProgressItem $progress) => $progress->getProgressType(),
                        $courseProgressItems
                    ),
                )
                ->getQuery()
                ->getResult();

            foreach ($courseProgressItems as $courseProgress) {
                $value = [
                    'score' => $courseProgress->getScore(),
                    'completeness' => $courseProgress->getCompleteness(),
                ];
                if (array_key_exists($courseProgress->getProgressId(), $existProgress)) {
                    $existProgress[$courseProgress->getProgressId()]->setValue($value);
                } else {
                    $progress = (new Progress())
                        ->setProgressId($courseProgress->getProgressId())
                        ->setProgressType($courseProgress->getProgressType())
                        ->setUser($user)
                        ->setValue($value);

                    $this->entityManager->persist($progress);

                    $existProgress[$courseProgress->getProgressId()] = $progress;
                }
            }
        }

        if (count($stepProgressItems) > 0) {
            $qb = $this->entityManager->createQueryBuilder();
            /** @var StepProgress[] $existsStepsProgress */
            $existsStepsProgress = $qb
                ->select('sp')
                ->from(StepProgress::class, 'sp', 'sp.stepId')
                ->andWhere($qb->expr()->eq('sp.user', ':user'))
                ->andWhere($qb->expr()->in('sp.stepId', ':stepIds'))
                ->setParameter('user', $user)
                ->setParameter(
                    'stepIds',
                    array_map(
                        static fn (ProgressItem $progressItem) => $progressItem->getProgressId(),
                        $stepProgressItems
                    ),
                )
                ->getQuery()
                ->getResult();

            foreach ($stepProgressItems as $stepProgressItem) {
                $value = [
                    'score' => $stepProgressItem->getScore(),
                    'completeness' => $courseProgress->getCompleteness(),
                ];
                if (array_key_exists($stepProgressItem->getProgressId(), $existsStepsProgress)) {
                    $existsStepsProgress[$stepProgressItem->getProgressId()]->setValue($value);
                } else {
                    $stepProgress = (new StepProgress())
                        ->setStepId($stepProgressItem->getProgressId())
                        ->setUser($user)
                        ->setValue($value);

                    $this->entityManager->persist($stepProgress);

                    $existsStepsProgress[$stepProgressItem->getProgressId()] = $stepProgress;
                }
            }
        }

        $this->entityManager->flush();
    }
}
