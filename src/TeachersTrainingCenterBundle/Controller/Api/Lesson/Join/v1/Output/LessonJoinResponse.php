<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\Join\v1\Output;

use Nelmio\ApiDocBundle\Annotation\Model;
use Skyeng\VimboxCoreRooms\API\Model\RoomWithNodesGroupedByParticipantsResponse;
use Swagger\Annotations as SWG;
use TeachersTrainingCenterBundle\Controller\Api\Lesson\Join\v1\Output\Model\ParticipantWithNodesResponse;

final class LessonJoinResponse
{
    /**
     * @SWG\Property(type="string", description="Generated url friendly hash room", example="kanobu")
     */
    public ?string $hash;

    /**
     * @SWG\Property(type="string", description="Timetable ID", example=1)
     */
    public ?string $timetableId;

    /**
     * @SWG\Property(
     *     type="string",
     *     example="math",
     *     description="Назначенный для проекта идентификатор.
     *     У проекта может быть несколько таких идентификаторов, если нужно разделять комнаты"
     * )
     */
    public ?string $scope;

    /**
     * @SWG\Property(
     *     type="string",
     *     format="date-time",
     *     description="Дата ожидаемого начала урока",
     *     example="2017-07-21T17:32:28Z"
     * )
     */
    public ?\DateTime $expectedStartAt;

    /**
     * @SWG\Property(
     *     type="string",
     *     format="date-time",
     *     description="Дата ожидаемого начала урока",
     *     example="2017-07-21T17:32:28Z"
     * )
     */
    public ?\DateTime $closedAt;

    /**
     * @SWG\Property(
     *     type="string",
     *     description="Метод ревизионирования в комнате (group или student)",
     *     example="personal"
     * )
     */
    public ?string $contentRevisionType;

    /**
     * @SWG\Property(
     *     type="integer",
     *     description="Идентификатор ревизии. Для группового занятия это id группы.",
     *     example="123"
     * )
     */
    public ?int $contentRevisionId;

    /**
     * @var string[]
     *
     * @SWG\Property(type="object", description="Any json payload")
     */
    public ?array $meta;

    /**
     * @var ParticipantWithNodesResponse[]
     *
     * @SWG\Property(type="array", @Model(type=ParticipantWithNodesResponse::class))
     */
    public ?array $participants;

    public function __construct(RoomWithNodesGroupedByParticipantsResponse $room)
    {
        $this->scope = $room->getScope();
        $this->hash = $room->getHash();
        $this->timetableId = $room->getTimetableId();
        $this->expectedStartAt = $room->getExpectedStartAt();
        $this->closedAt = $room->getClosedAt();
        /** @psalm-suppress InvalidPropertyAssignmentValue */
        $this->meta = $room->getMeta();
        $this->contentRevisionId = $room->getContentRevisionId();
        $this->contentRevisionType = $room->getContentRevisionType();

        if (count($room->getParticipants()) > 0) {
            foreach ($room->getParticipants() as $participant) {
                $this->participants[] = new ParticipantWithNodesResponse($participant);
            }
        }
    }
}
