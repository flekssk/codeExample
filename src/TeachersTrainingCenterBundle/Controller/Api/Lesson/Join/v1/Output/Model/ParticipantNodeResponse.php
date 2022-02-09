<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\Join\v1\Output\Model;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

final class ParticipantNodeResponse
{
    /**
     * @SWG\Property(type="integer", description="Node ID", example=1)
     */
    public int $id;

    /**
     * @SWG\Property(type="string", example="Node title", description="")
     */
    public ?string $title;

    /**
     * @SWG\Property(type="string", example="Node type", description="")
     */
    public ?string $type;

    /**
     * @var string[]
     *
     * @SWG\Property(type="object", description="Node meta")
     */
    public ?array $meta;

    /**
     * @SWG\Property(type="integer", description="Participant score", example=50)
     */
    public ?int $score;

    /**
     * @SWG\Property(type="integer", description="Participant completeness", example=100)
     */
    public ?int $completeness;

    /**
     * @var ParticipantNodeStepResponse[]|null
     *
     * @SWG\Property(type="array", @Model(type=ParticipantNodeStepResponse::class))
     */
    public ?array $steps = [];

    public function __construct(\Skyeng\VimboxCoreRooms\API\Model\ParticipantNodeResponse $nodeParticipant)
    {
        $this->id = $nodeParticipant->getId();
        $this->title = $nodeParticipant->getTitle();
        $this->type = $nodeParticipant->getType();
        /** @psalm-suppress InvalidPropertyAssignmentValue */
        $this->meta = $nodeParticipant->getMeta();
        $this->score = $nodeParticipant->getScore();
        $this->completeness = $nodeParticipant->getCompleteness();

        foreach ($nodeParticipant->getSteps() as $step) {
            $this->steps[] = new ParticipantNodeStepResponse($step);
        }
    }
}
