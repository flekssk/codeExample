<?php

namespace TeachersTrainingCenterBundle\Controller\Api\Content\Step\v1\Input;

use TeachersTrainingCenterBundle\Entity\Traits\SafeLoadFieldsTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Swagger\Annotations as SWG;

final class LoadStepRequest
{
    use SafeLoadFieldsTrait;

    /**
     * @SWG\Property(type="integer", description="ID пользователя, чью версию нужно загрузить")
     * @Assert\Type(type="numeric")
     */
    public $studentId;

    /**
     * @SWG\Property(type="string", description="UUID-идентификатор степа")
     * @Assert\NotNull()
     * @Assert\Type(type="string")
     */
    public $stepUuid;

    /**
     * @SWG\Property(type="string", description="Зарузить последнюю ревизию степа")
     * @Assert\Type(type="string")
     */
    public $last;

    private $safeFields = ['studentId', 'stepUuid', 'last'];
}
