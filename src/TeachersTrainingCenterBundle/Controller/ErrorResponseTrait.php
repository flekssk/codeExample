<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Controller;

use FOS\RestBundle\View\View;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface as ValidationErrors;

trait ErrorResponseTrait
{
    private function createErrorResponse(int $code, string $propertyPath, string $message): View
    {
        return View::create(new ErrorResponse(new Error($propertyPath, $message)), $code);
    }

    private function createValidationErrorResponse(int $code, ValidationErrors $validationErrors): View
    {
        $errors = [];
        foreach ($validationErrors as $error) {
            /** @var ConstraintViolationInterface $error */
            $errors[] = new Error($error->getPropertyPath(), (string) $error->getMessage());
        }

        return View::create(new ErrorResponse(...$errors), $code);
    }
}
