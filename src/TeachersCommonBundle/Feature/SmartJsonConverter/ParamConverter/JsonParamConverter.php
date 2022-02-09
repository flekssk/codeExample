<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\SmartJsonConverter\ParamConverter;

use JMS\Serializer\SerializerInterface;
use Opis\JsonSchema\ISchemaLoader;
use Opis\JsonSchema\IValidator;
use ReflectionClass;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use TeachersCommonBundle\Feature\SmartJsonConverter\Service\Interfaces\ErrorToConstraintViolationConverterInterface;
use TeachersCommonBundle\Feature\SmartJsonConverter\Service\JsonDecoder;

class JsonParamConverter implements ParamConverterInterface
{
    private const CONVERTER_NAME = 'server_api.json_body_converter';

    private ISchemaLoader $schemaLoader;

    private IValidator $validator;

    private SerializerInterface $serializer;

    private ErrorToConstraintViolationConverterInterface $errorConverter;

    private JsonDecoder $jsonDecoder;

    public function __construct(
        ISchemaLoader $schemaLoader,
        IValidator $validator,
        SerializerInterface $serializer,
        ErrorToConstraintViolationConverterInterface $errorConverter,
        JsonDecoder $jsonDecoder
    ) {
        $this->schemaLoader = $schemaLoader;
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->errorConverter = $errorConverter;
        $this->jsonDecoder = $jsonDecoder;
    }

    public function apply(Request $request, ParamConverter $configuration): bool
    {
        try {
            $options = $this->getOptions($configuration);

            $schemaUri = strlen($options['schema']) > 0
                ? $options['schema']
                : sprintf(
                    '/%s.json',
                    (new ReflectionClass($configuration->getClass()))->getShortName()
                );

            if (strpos($schemaUri, '/') !== 0) {
                $schemaUri = '/' . $schemaUri;
            }

            $schema = $this->schemaLoader->loadSchema($schemaUri);

            if ($schema === null) {
                throw new \Exception('Fail to load schema');
            }

            $data = $this->jsonDecoder->decodeJson($request->getContent());

            $result = $this->validator->schemaValidation($data, $schema, -1, $this->schemaLoader);

            $request->attributes->set(
                'validationErrors',
                $this->errorConverter->convertValidationResultToViolationList($result, 'requestBody')
            );

            if ($result->isValid()) {
                $deserializedRequest = $this->serializer->deserialize(
                    $request->getContent(),
                    $configuration->getClass(),
                    'json'
                );

                $request->attributes->set($configuration->getName(), $deserializedRequest);
            }
        } catch (\Throwable $e) {
            $errors = new ConstraintViolationList([
                new ConstraintViolation(
                    $e->getMessage(),
                    $e->getMessage(),
                    [],
                    null,
                    null,
                    null
                ),
            ]);

            $request->attributes->set('validationErrors', $errors);
        }

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getConverter() === self::CONVERTER_NAME;
    }

    /**
     * @return string[]
     */
    protected function getOptions(ParamConverter $configuration): array
    {
        return array_replace(
            [
                'schema' => '',
            ],
            $configuration->getOptions()
        );
    }
}
