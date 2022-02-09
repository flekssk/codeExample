<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\SmartJsonConverter\Service;

use Opis\JsonSchema\ValidationError;
use Opis\JsonSchema\ValidationResult;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use TeachersCommonBundle\Feature\SmartJsonConverter\Service\Interfaces\ErrorToConstraintViolationConverterInterface;

class ErrorToConstraintViolationConverter implements ErrorToConstraintViolationConverterInterface
{
    public function convertValidationResultToViolationList(
        ValidationResult $result,
        string $rootProperty = ''
    ): ConstraintViolationListInterface {
        $list = new ConstraintViolationList();

        foreach ($result->getErrors() as $error) {
            $list->add(
                $this->convertErrorToViolation($error, $rootProperty)
            );
        }

        return $list;
    }

    public function convertErrorToViolation(
        ValidationError $error,
        string $rootProperty = ''
    ): ConstraintViolationInterface {
        $propertyPath = implode('.', $error->dataPointer());

        switch ($error->keyword()) {
            case 'required':
                $errorMessage = 'Field is required';

                if (strlen($propertyPath) > 0) {
                    $propertyPath .= '.';
                }

                $propertyPath .= $error->keywordArgs()['missing'];

                break;
            case 'type':
                $errorMessage = sprintf(
                    'Invalid type: must be %s, %s found',
                    is_array($error->keywordArgs()['expected'])
                        ? implode(' or ', $error->keywordArgs()['expected'])
                        : $error->keywordArgs()['expected'],
                    $error->keywordArgs()['used']
                );

                break;
            case 'enum':
                $expected = array_map([$this, 'toString'], $error->keywordArgs()['expected']);

                $errorMessage = sprintf(
                    'Value must be one of [%s], %s found',
                    implode(', ', $expected),
                    $this->toString($error->data())
                );

                break;
            case 'additionalProperties':
                $extraPropertiesFound = array_map(
                    static function (ValidationError $e): string {
                        return sprintf('[%s]', implode('.', $e->dataPointer()));
                    },
                    $error->subErrors()
                );

                $errorMessage = sprintf(
                    'No additional properties allowed, found %s',
                    implode(', ', $extraPropertiesFound)
                );

                break;
            case 'minimum':
                $errorMessage = sprintf(
                    'Value must be greater than or equal to %s',
                    $error->keywordArgs()['min']
                );

                break;
            case 'maximum':
                $errorMessage = sprintf(
                    'Value must be less than or equal to %s',
                    $error->keywordArgs()['max']
                );

                break;
            case 'minLength':
                $errorMessage = sprintf(
                    'Value must be at least %d character(s) long',
                    $error->keywordArgs()['min']
                );

                break;
            case 'maxLength':
                $errorMessage = sprintf(
                    'Value must not exceed %d character(s)',
                    $error->keywordArgs()['max']
                );

                break;
            case 'minItems':
                $errorMessage = sprintf(
                    'Array must contain at least %d item(s), %d found',
                    $error->keywordArgs()['min'],
                    $error->keywordArgs()['count']
                );

                break;
            case 'maxItems':
                $errorMessage = sprintf(
                    'Array must contain no more than %d item(s), %d found',
                    $error->keywordArgs()['max'],
                    $error->keywordArgs()['count']
                );

                break;
            case 'pattern':
                $errorMessage = sprintf(
                    'Invalid value pattern, must be %s',
                    $error->keywordArgs()['pattern']
                );

                break;
            case 'uniqueItems':
                $errorMessage = 'Array items must be unique';

                $duplicateItem = $error->keywordArgs()['duplicate'] ?? null;

                if (is_scalar($duplicateItem)) {
                    /**
                     * @psalm-suppress InvalidScalarArgument
                     */
                    $errorMessage .= sprintf(', at least one duplicate found: "%s"', $duplicateItem);
                }

                break;
            case '$filters':
                $errorMessage = sprintf(
                    'Fail to check against [%s] validation filter',
                    $error->keywordArgs()['filter']
                );

                break;
            default:
                $argumentTokens = [];

                foreach ($error->keywordArgs() as $arg => $val) {
                    $argumentTokens[] = sprintf('%s: "%s"', $arg, $val);
                }

                $errorMessage = sprintf(
                    'JSON schema validation error with keyword "%s", arguments: %s',
                    $error->keyword(),
                    implode(', ', $argumentTokens)
                );
        }

        if (strlen($propertyPath) === 0 && strlen($rootProperty) > 0) {
            $propertyPath = $rootProperty;
        }

        return new ConstraintViolation(
            $errorMessage,
            $errorMessage,
            [],
            null,
            $propertyPath,
            $error->data(),
            null,
            'not_valid'
        );
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingAnyTypeHint
     */
    private function toString($value): string
    {
        if (is_array($value)) {
            return '"' . implode(', ', $value) . '"';
        }

        if ($value === null) {
            return 'null';
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_string($value)) {
            return '"' . $value . '"';
        }

        return (string) $value;
    }
}
