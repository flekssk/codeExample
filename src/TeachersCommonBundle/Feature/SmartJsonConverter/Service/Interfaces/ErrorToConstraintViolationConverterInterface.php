<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\SmartJsonConverter\Service\Interfaces;

use Opis\JsonSchema\ValidationError;
use Opis\JsonSchema\ValidationResult;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

interface ErrorToConstraintViolationConverterInterface
{
    public function convertValidationResultToViolationList(
        ValidationResult $result,
        string $rootProperty = ''
    ): ConstraintViolationListInterface;

    public function convertErrorToViolation(
        ValidationError $error,
        string $rootProperty = ''
    ): ConstraintViolationInterface;
}
