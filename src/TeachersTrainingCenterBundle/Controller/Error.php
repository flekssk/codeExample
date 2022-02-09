<?php

namespace TeachersTrainingCenterBundle\Controller;

use Swagger\Annotations as SWG;

class Error
{
    /**
     * @SWG\Property(type="string", example="common")
     */
    public $property_path;

    /**
     * @SWG\Property(type="string", example="Сообщение об ошибке")
     */
    public $message;

    public function __construct(string $property_path, string $message)
    {
        $this->property_path = $property_path;
        $this->message = $message;
    }
}
