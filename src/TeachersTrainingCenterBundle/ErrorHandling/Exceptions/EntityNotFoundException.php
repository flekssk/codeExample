<?php

namespace TeachersTrainingCenterBundle\ErrorHandling\Exceptions;

final class EntityNotFoundException extends \RuntimeException
{
    public function __construct($message = 'Not found')
    {
        parent::__construct($message);
    }
}
