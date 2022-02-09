<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\Create\v1;

use JsonMapper_Exception;
use Skyeng\VimboxCoreRooms\API\ComplexApi;
use Skyeng\VimboxCoreRooms\API\Model\NodeCreateRequest;
use Skyeng\VimboxCoreRooms\API\Model\NodeUpdateStepRequest;
use Skyeng\VimboxCoreRooms\API\Model\ParticipantCreateRequest;
use Skyeng\VimboxCoreRooms\API\Model\RoomCreateRequest;
use Skyeng\VimboxCoreRooms\API\Model\RoomCreateWithNodeRequest;
use Skyeng\VimboxCoreRooms\API\Model\RoomCreateWithStepsRequest;
use Skyeng\VimboxCoreRooms\API\Model\RoomNodeResponse;
use Skyeng\VimboxCoreRooms\API\Model\RoomResponse;
use Skyeng\VimboxCoreRooms\ApiException;
use TeachersTrainingCenterBundle\Api\ContentApi\ContentApi;
use TeachersTrainingCenterBundle\Api\ContentApi\Model\LessonInfoWithPlan\LessonInfoWithPlan;
use TeachersTrainingCenterBundle\Api\ContentApi\Model\LessonInfoWithPlan\Step;
use TeachersTrainingCenterBundle\Entity\LessonNode;
use TeachersTrainingCenterBundle\Entity\Progress;
use TeachersTrainingCenterBundle\ErrorHandling\Exceptions\EntityNotFoundException;
use TeachersTrainingCenterBundle\Repository\LessonNodeRepository;
use TeachersTrainingCenterBundle\Repository\UserRepository;
use TeachersTrainingCenterBundle\Service\UserService;

class LessonCreateManager
{
    private ContentApi $contentApi;
    private UserRepository $userRepository;
    private LessonNodeRepository $lessonNodeRepository;
    private ComplexApi $roomComplexApi;
    private UserService $userService;

    public function __construct(
        ComplexApi $roomComplexApi,
        ContentApi $contentApi,
        UserRepository $userRepository,
        LessonNodeRepository $lessonNodeRepository,
        UserService $userService
    ) {
        $this->contentApi = $contentApi;
        $this->userRepository = $userRepository;
        $this->lessonNodeRepository = $lessonNodeRepository;
        $this->roomComplexApi = $roomComplexApi;
        $this->userService = $userService;
    }

    /**
     * Создает self-study урок для переданного userId
     *
     * @throws JsonMapper_Exception
     * @throws ApiException
     */
    public function createLesson(int $lessonId, int $userId): RoomResponse
    {
        $structure = $this->contentApi->getLessonInfoWithPlan($lessonId);

        $this->userService->ensureUsersExistByIds([$userId]);
        $student = $this->userRepository->find($userId);

        if (is_null($student)) {
            throw new EntityNotFoundException('Cant create lesson: not found necessary entities');
        }

        $lessonNode = $this->lessonNodeRepository->findOneBy([
            'student' => $student,
            'lessonId' => $lessonId,
        ]);

        if (!is_null($lessonNode)) {
            $response = $this->createRoomWithExistingNode($userId, $lessonNode);
        } else {
            $response = $this->createRoomWithNewNode($lessonId, $userId, $structure);
            $this->lessonNodeRepository->create($student, $lessonId, $response->getNode()->getId());
        }

        return $response->getRoom();
    }

    /**
     * @throws ApiException
     */
    public function createRoomWithExistingNode(int $userId, LessonNode $lessonNode): RoomNodeResponse
    {
        $payload = new RoomCreateWithNodeRequest();
        $payload->setNodeId($lessonNode->getNodeId());
        $payload->setRoom($this->createRoomRequest($userId, $lessonNode->getLessonId()));

        return $this->roomComplexApi->complexV1RoomCreateWithNode($payload);
    }

    /**
     * @throws ApiException
     */
    public function createRoomWithNewNode(int $lessonId, int $userId, LessonInfoWithPlan $lesson): RoomNodeResponse
    {
        $payload = new RoomCreateWithStepsRequest();
        $payload->setRoom($this->createRoomRequest($userId, $lessonId));

        $nodeMeta = new \stdClass();
        $nodeMeta->id = $lessonId;

        $payload->setNode(
            (new NodeCreateRequest())
                ->setType(Progress::PROGRESS_TYPE_LESSON)
                ->setTitle(
                    $lesson
                        ->getLessonInfo()
                        ->getTitle(),
                )
                ->setMeta($nodeMeta),
        );

        $payload->setSteps($this->getLessonStepsRequest($lesson, 'lesson'));

        return $this->roomComplexApi->complexV1RoomCreateWithSteps($payload);
    }

    /**
     * @return NodeUpdateStepRequest[]
     */
    private function getLessonStepsRequest(LessonInfoWithPlan $lesson, string $type): array
    {
        $stepGroups = [];
        foreach ($lesson->getLessonPlan() as $planByType) {
            $metaType = strtolower($planByType->getType());
            if ($metaType === $type) {
                $stepGroups[] = array_map(static function (Step $step) use ($metaType) {
                    $meta = new \stdClass();
                    $meta->type = $metaType;
                    $meta->title = $step->getTitle();

                    return (new NodeUpdateStepRequest())->setStepId($step->getStepUUID())->setMeta($meta);
                }, $planByType->getSteps());
            }
        }

        return array_merge(...$stepGroups);
    }

    private function createRoomRequest(int $userId, int $lessonId): RoomCreateRequest
    {
        $lessonAchievements = $this->contentApi->getLessonAchievements($lessonId);

        $meta = new \stdClass();
        $meta->achievements = $lessonAchievements;

        $payload = new RoomCreateRequest();
        $payload->setContentRevisionId($userId);
        $payload->setContentRevisionType('personal');
        $payload->setExpectedStartAt(new \DateTime());
        $payload->setScope('ttc');
        $payload->setMeta($meta);

        $participants = [
            (new ParticipantCreateRequest())
                ->setIdentityId($userId)
                ->setIdentityType(ParticipantCreateRequest::IDENTITY_TYPE_USER_ID)
                ->setShouldLinkWithNode(1)
                ->setRole('student')
                ->setMeta($meta),
        ];

        $payload->setParticipants($participants);

        return $payload;
    }
}
