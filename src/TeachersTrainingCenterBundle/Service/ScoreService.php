<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Service;

use TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output\Model\Course;
use TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output\Model\Group;
use TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output\Model\Lesson;
use TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output\Model\Level;
use TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\Output\Model\StructureItem;
use TeachersTrainingCenterBundle\Controller\Api\Content\GetStructure\v1\StructureManager;
use TeachersTrainingCenterBundle\DTO\Score;
use TeachersTrainingCenterBundle\Entity\Progress;
use TeachersTrainingCenterBundle\Entity\User;
use TeachersTrainingCenterBundle\ErrorHandling\Exceptions\EntityNotFoundException;
use TeachersTrainingCenterBundle\RabbitMq\Consumer\Score\Input\NodeScoreChangedMessage;
use TeachersTrainingCenterBundle\Repository\ProgressRepository;

class ScoreService
{
    private const NODE_META_ID = 'id';
    private const USER_IDENTITY_TYPE = 'userId';

    /**
     * @var Group[]
     */
    private array $structure;

    private ProgressRepository $progressRepository;

    private UserService $userService;

    public function __construct(
        StructureManager $structureManager,
        ProgressRepository $progressRepository,
        UserService $userService
    ) {
        $this->progressRepository = $progressRepository;
        $this->userService = $userService;

        $this->structure = $structureManager->getStructure();
    }

    public function updateScores(NodeScoreChangedMessage $message): void
    {
        /** @psalm-suppress InvalidArrayAccess */
        if (!isset($message->getNode()->getMeta()[self::NODE_META_ID])) {
            throw new \UnexpectedValueException('UpdateScoreMessage has no lessonId');
        }

        if ($message->getNodeParticipant()->getIdentityType() !== self::USER_IDENTITY_TYPE) {
            throw new \UnexpectedValueException('UpdateScoreMessage has unexpected identity type');
        }

        /** @psalm-suppress InvalidArrayAccess */
        $lessonId = $message->getNode()->getMeta()[self::NODE_META_ID];
        $studentId = $message->getNodeParticipant()->getIdentityId();

        $score = new Score();
        $score->score = $message->getNodeParticipant()->getScore();
        $score->completeness = $message->getNodeParticipant()->getCompleteness();

        $users = $this->userService->ensureUsersExistByIds([$studentId]);
        if (count($users) < 1) {
            throw new EntityNotFoundException("No user found for userId {$studentId}");
        }

        $user = $users[0];

        $item = $this->findLessonInStructure($this->structure, (int) $lessonId);
        $scoreChanged = true;
        while ($item && $scoreChanged) {
            $scoreChanged = $this->updateItemScore($item, $user, $score);
            if ($scoreChanged) {
                // no score changes - no need to calc for parent items
                $item = $this->findStructureItemParent($this->structure, $item);
                $score = $this->getItemScore($item, $user);
            }
        }
    }

    private function updateItemScore(StructureItem $item, User $user, Score $score): bool
    {
        $itemProgressType = self::getProgressTypeIfSupported($item);
        if (!$itemProgressType) {
            // progress not stored for this item type
            return false;
        }

        $progressItem = $this->progressRepository->findOneBy([
            'user' => $user,
            'progressId' => $item->id,
            'progressType' => $itemProgressType,
        ]);
        if ($progressItem) {
            if ($score->equals(Score::fromArray($progressItem->getValue()))) {
                // no score changes
                return false;
            }

            $this->progressRepository->updateValue($progressItem, $score->toArray());
        } else {
            $this->progressRepository->create((string) $item->id, $itemProgressType, $user, $score->toArray());
        }

        return true;
    }

    private function getItemScore(StructureItem $item, User $user): Score
    {
        $itemType = null;
        $itemIds = [];
        foreach ($item->getChildren() as $childItem) {
            $itemType = self::getProgressTypeIfSupported($childItem);
            $itemIds[] = $childItem->id;
        }

        $progressItems = $this->progressRepository->findBy([
            'user' => $user,
            'progressId' => $itemIds,
            'progressType' => $itemType,
        ]);

        return $this->calcScore(count($item->getChildren()), $progressItems);
    }

    /**
     * @param Progress[] $progressItems
     */
    private function calcScore(int $itemChildrenCount, array $progressItems): Score
    {
        $score = new Score();
        foreach ($progressItems as $progressItem) {
            $itemScore = Score::fromArray($progressItem->getValue());
            $score->score += $itemScore->score;
            $score->completeness += $itemScore->completeness;
        }

        $score->completeness /= $itemChildrenCount;

        return $score;
    }

    /**
     * @param Group[] $structure
     */
    private function findLessonInStructure(array $structure, int $lessonId): ?Lesson
    {
        foreach ($structure as $group) {
            foreach ($group->courses as $course) {
                foreach ($course->levels as $level) {
                    foreach ($level->lessons as $lesson) {
                        if ($lesson->id === $lessonId) {
                            return $lesson;
                        }
                    }
                }
            }
        }

        return null;
    }

    /**
     * @param StructureItem[] $structure
     */
    private function findStructureItemParent(array $structure, StructureItem $item): ?StructureItem
    {
        foreach ($structure as $elem) {
            if ($elem->getChildren()) {
                if (in_array($item, $elem->getChildren(), true)) {
                    return $elem;
                }

                $nestedFind = $this->findStructureItemParent($elem->getChildren(), $item);
                if ($nestedFind) {
                    return $nestedFind;
                }
            }
        }

        return null;
    }

    private static function getProgressTypeIfSupported(StructureItem $item): ?string
    {
        switch (get_class($item)) {
            case Course::class:
                return Progress::PROGRESS_TYPE_COURSE;
            case Lesson::class:
                return Progress::PROGRESS_TYPE_LESSON;
            case Level::class:
                return Progress::PROGRESS_TYPE_LEVEL;
            default:
                return null;
        }
    }
}
