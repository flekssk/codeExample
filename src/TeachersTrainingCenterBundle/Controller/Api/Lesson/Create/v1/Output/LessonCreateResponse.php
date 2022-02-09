<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\Create\v1\Output;

use Skyeng\VimboxCoreRooms\API\Model\RoomResponse;
use Swagger\Annotations as SWG;

final class LessonCreateResponse
{
    /**
     * @SWG\Property(type="string", description="roomHash")
     */
    public string $roomHash;

    /**
     * @var string[]|null
     *
     * @SWG\Property(type="object", description="Node meta")
     */
    public ?array $meta;

    /**
     * @psalm-suppress InvalidArrayAccess
     */
    public function __construct(RoomResponse $roomResponse)
    {
        $this->roomHash = $roomResponse->getHash();
        /** @psalm-suppress InvalidPropertyAssignmentValue */
        $this->meta = $roomResponse->getMeta();
    }
}
