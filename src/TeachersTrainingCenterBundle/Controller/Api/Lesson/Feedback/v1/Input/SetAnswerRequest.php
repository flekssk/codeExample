<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Lesson\Feedback\v1\Input;

use TeachersTrainingCenterBundle\Entity\Traits\SafeLoadFieldsTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

final class SetAnswerRequest
{
    use SafeLoadFieldsTrait;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @SWG\Property(type="string", description="Human-readable id", example="VIDEO_QUALITY")
     */
    public $questionAlias;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @SWG\Property(type="string", description="E.g. room hash or date to limit how many answers can be given per period", example="roomhash")
     */
    public $periodId;

    /**
     * @var integer
     *
     * @Assert\Range(min=1)
     * @Assert\Type(type="numeric")
     * @SWG\Property(type="integer", description="Mark like excellent", example=5)
     */
    public $answerMark;

    /**
     * @var string
     *
     * @Assert\Type(type="string")
     * @SWG\Property(type="string", description="Comment or answer's text", example="Thanks")
     */
    public $answerComment;

    /**
     * @var array
     *
     * @Assert\Type(type="array")
     * @SWG\Property(type="array", description="Additional data", @SWG\Items(type="string"))
     */
    public $payload;

    private $safeFields = ['questionAlias', 'periodId', 'answerMark', 'answerComment', 'payload'];
}
