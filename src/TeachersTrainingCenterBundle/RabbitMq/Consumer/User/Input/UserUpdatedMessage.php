<?php

namespace TeachersTrainingCenterBundle\RabbitMq\Consumer\User\Input;

use TeachersTrainingCenterBundle\Entity\Traits\SafeLoadFieldsTrait;
use Symfony\Component\Validator\Constraints as Assert;

final class UserUpdatedMessage
{
    use SafeLoadFieldsTrait;

    /**
     * @Assert\NotBlank()
     * @Assert\Type(type="numeric")
     */
    public $id;

    /**
     * @Assert\Type(type="string")
     */
    public $name;

    /**
     * @Assert\Type(type="string")
     */
    public $surname;

    /**
     * @Assert\Type(type="string")
     */
    public $avatarUrl;

    /**
     * @Assert\Type(type="string")
     */
    public $locale;

    /**
     * @Assert\Type(type="string")
     */
    public $timezone;

    private $safeFields = ['id', 'name', 'surname', 'avatarUrl', 'locale', 'timezone'];
}
