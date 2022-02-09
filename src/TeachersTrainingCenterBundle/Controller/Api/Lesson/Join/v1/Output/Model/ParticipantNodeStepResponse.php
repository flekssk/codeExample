<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\Join\v1\Output\Model;

use Swagger\Annotations as SWG;

final class ParticipantNodeStepResponse
{
    /**
     * @SWG\Property(type="string", example="123456", description="")
     */
    public ?string $stepId;

    /**
     * @SWG\Property(type="string", example="Some step", description="")
     */
    public ?string $title;

    /**
     * @SWG\Property(type="integer", description="Баллы за степ для юзера", example=50)
     */
    public ?int $score;

    /**
     * @SWG\Property(type="integer", description="Процент завершенности степа для юзера", example=100)
     */
    public ?int $completeness;

    /**
     * @SWG\Property(
     *     type="string",
     *     format="date-time",
     *     description="Дата пропуска степа юзером",
     *     example="2017-07-21T17:32:28Z"
     * )
     */
    public ?\DateTime $skippedAt;

    public function __construct(\Skyeng\VimboxCoreRooms\API\Model\ParticipantNodeStepResponse $nodeStepParticipant)
    {
        $this->stepId = $nodeStepParticipant->getStepId();
        /** @psalm-suppress InvalidArrayAccess */
        $this->title = $nodeStepParticipant->getStepMeta()['title'];
        $this->score = $nodeStepParticipant->getScore();
        $this->completeness = $nodeStepParticipant->getCompleteness();
        $this->skippedAt = $nodeStepParticipant->getSkippedAt();
    }
}
