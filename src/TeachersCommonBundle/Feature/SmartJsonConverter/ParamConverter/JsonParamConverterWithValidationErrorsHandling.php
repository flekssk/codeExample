<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\SmartJsonConverter\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use TeachersCommonBundle\Feature\ConventionalResponse\Exception\ValidationException;
use TeachersCommonBundle\Feature\SmartJsonConverter\DTO\SmartJsonRequestDTO;

class JsonParamConverterWithValidationErrorsHandling implements ParamConverterInterface
{
    private const CUSTOM_CONVERTER_NAME = 'json_schema_converter.with_validation_errors_handling';

    private JsonParamConverter $converter;

    private ValidatorInterface $validator;

    public function __construct(JsonParamConverter $converter, ValidatorInterface $validator)
    {
        $this->converter = $converter;
        $this->validator = $validator;
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $this->converter->apply($request, $configuration);

        $this->addErrorsByAssertValidator($request, $configuration);

        $this->throwOnValidationErrors($request);

        return false;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $this->supportByConverterName($configuration) ||
            $this->supportByParameterInterface($configuration);
    }

    private function supportByParameterInterface(ParamConverter $configuration): bool
    {
        $controllerParameterName = $configuration->getClass();

        if ($controllerParameterName === null || $controllerParameterName === '') {
            return false;
        }

        return \in_array(SmartJsonRequestDTO::class, class_implements($configuration->getClass()), true);
    }

    private function supportByConverterName(ParamConverter $configuration): bool
    {
        return $configuration->getConverter() === self::CUSTOM_CONVERTER_NAME;
    }

    private function throwOnValidationErrors(Request $request): void
    {
        /** @var ConstraintViolationListInterface $validationErrors */
        $validationErrors = $request->attributes->get('validationErrors');

        if (
            $validationErrors !== null
            && count($validationErrors) > 0
            && in_array(ConstraintViolationListInterface::class, class_implements($validationErrors), true)
        ) {
            throw new ValidationException($validationErrors);
        }
    }

    /**
     * Дополнительная валидация с помощью Symfony Validator,
     * для возможности валидировать входной параметр через аннотации
     */
    private function addErrorsByAssertValidator(Request $request, ParamConverter $configuration): void
    {
        $requestDTO = $request->attributes->get($configuration->getName());

        if ($requestDTO === null) {
            return;
        }

        $assertErrors = $this->validator->validate($requestDTO);

        /** @var ConstraintViolationListInterface $jsonSchemaErrors */
        $jsonSchemaErrors = $request->attributes->get('validationErrors');

        $jsonSchemaErrors->addAll($assertErrors);
    }
}
