<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Content\Step\v1\Output;

use Skyeng\VimboxCoreStepStore\API\Model\StepLoadResponse;
use Swagger\Annotations as SWG;

final class LoadStepResponse
{
    /**
     * @var string
     * @SWG\Property(type="string", description="Step content")
     */
    public $content;

    /**
     * @var boolean
     * @SWG\Property(type="boolean", description="True if step has exercises", example="true")
     */
    public $isInteractive;

    /**
     * @var int
     * @SWG\Property(type="integer", description="StepRevId", example="1")
     */
    public $stepRevId;

    public function __construct(StepLoadResponse $stepLoadResponse)
    {
        $this->content = $stepLoadResponse->getContent();
        $this->isInteractive = $stepLoadResponse->getIsInteractive();
        $this->stepRevId = $stepLoadResponse->getId();
    }
}
