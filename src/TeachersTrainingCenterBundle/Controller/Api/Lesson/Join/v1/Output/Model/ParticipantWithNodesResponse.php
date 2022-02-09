<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\Join\v1\Output\Model;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

final class ParticipantWithNodesResponse
{
    /**
     * @var int
     * @SWG\Property(type="integer", example=123)
     */
    public $identityId;

    /**
     * @var string
     * @SWG\Property(type="string", example="userId", description="")
     */
    public $identityType;

    /**
     * @var string
     * @SWG\Property(type="string", example="student", description="")
     */
    public $role;

    /**
     * @var array|null
     * @SWG\Property(type="array", @Model(type=ParticipantNodeResponse::class))
     */
    public $nodes = [];

    public function __construct(\Skyeng\VimboxCoreRooms\API\Model\ParticipantWithNodesResponse $participant)
    {
        $this->identityType = $participant->getIdentityType();
        $this->identityId = $participant->getIdentityId();
        $this->role = $participant->getRole();

        foreach ($participant->getNodes() as $nodeParticipant) {
            $this->nodes[] = new ParticipantNodeResponse($nodeParticipant);
        }
    }
}
