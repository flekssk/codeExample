<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\Join\v1;

use TeachersTrainingCenterBundle\Controller\Api\Lesson\Join\v1\Input\LessonJoinRequest;
use Skyeng\VimboxCoreRooms\API\Model\RoomJoinRequest;
use Skyeng\VimboxCoreRooms\API\Model\RoomResponse;
use Skyeng\VimboxCoreRooms\API\Model\RoomWithNodesGroupedByParticipantsResponse;
use Skyeng\VimboxCoreRooms\API\NodeApi;
use Skyeng\VimboxCoreRooms\API\RoomApi;

class LessonJoinManager
{
    /**
     * @var RoomApi
     */
    private $roomApi;

    public function __construct(RoomApi $roomApi)
    {
        $this->roomApi = $roomApi;
    }

    public function joinLesson(
        int $userId,
        LessonJoinRequest $lessonJoinRequest
    ): RoomWithNodesGroupedByParticipantsResponse {
        $payload = (new RoomJoinRequest())
            ->setIdentityId($userId)
            ->setIdentityType(RoomJoinRequest::IDENTITY_TYPE_USER_ID)
            ->setMeta($lessonJoinRequest->meta)
            ->setRoomHash($lessonJoinRequest->roomHash);

        return $this->roomApi->v1RoomJoin($payload);
    }
}
