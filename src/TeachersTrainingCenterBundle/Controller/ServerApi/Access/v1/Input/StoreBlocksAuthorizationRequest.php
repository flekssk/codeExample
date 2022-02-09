<?php

namespace TeachersTrainingCenterBundle\Controller\ServerApi\Access\v1\Input;

use TeachersTrainingCenterBundle\Entity\Traits\SafeLoadFieldsTrait;
use Symfony\Component\Validator\Constraints as Assert;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

final class StoreBlocksAuthorizationRequest
{
    use SafeLoadFieldsTrait;

    public const ACTION_BLOCK_SAVE = 'block.save';
    public const ACTION_BLOCK_LIST = 'block.list';
    public const ACTION_BLOCK_DELETE = 'block.delete';


    /**
     * @var AccessAction
     * @Assert\NotBlank()
     * @Assert\Valid()
     * @SWG\Property(type="object", @Model(type=AccessAction::class))
     */
    private $action;

    /**
     * @var AccessUser
     * @Assert\NotBlank()
     * @Assert\Valid()
     * @SWG\Property(type="object", @Model(type=AccessUser::class))
     */
    private $user;

    private $safeFields = ['user', 'action'];

    private $safeFieldsTypes = [
        'user' => [
            'type' => 'class',
            'class' => AccessUser::class,
        ],
        'action' => [
            'type' => 'class',
            'class' => AccessAction::class,
        ],
    ];

    public function getAction(): AccessAction
    {
        return $this->action;
    }

    public function getUser(): AccessUser
    {
        return $this->user;
    }
}
