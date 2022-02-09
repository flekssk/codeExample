<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ConventionalResponse\Exception;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends \RuntimeException
{
    private ConstraintViolationListInterface $violationList;

    public function __construct(ConstraintViolationListInterface $errors, ?\Throwable $previous = null)
    {
        $this->violationList = $errors;

        parent::__construct(
            $errors[0]->getPropertyPath() . ': ' . $errors[0]->getMessage(),
            Response::HTTP_BAD_REQUEST,
            $previous
        );
    }

    public function violationList(): ConstraintViolationListInterface
    {
        return $this->violationList;
    }
}
