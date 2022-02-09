<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Api\Crm2Api;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use TeachersTrainingCenterBundle\Api\Crm2Api\Model\GetEducationServiceResponse;
use TeachersTrainingCenterBundle\Api\Crm2Api\Model\GetStudentEducationServiceResponse;

class Crm2Api
{
    private Client $crm2ApiClient;

    private LoggerInterface $logger;

    private ValidatorInterface $validator;

    public function __construct(Client $crm2ApiClient, LoggerInterface $logger, ValidatorInterface $validator)
    {
        $this->crm2ApiClient = $crm2ApiClient;
        $this->logger = $logger;
        $this->validator = $validator;
    }

    /**
     * @return GetStudentEducationServiceResponse[]
     */
    public function getStudentsEducationServices(int $teacherId): array
    {
        $response = (array)$this->get("/server-api/anti-corruption/v2/teachers/{$teacherId}/education-services/");
        if (!isset($response['educationServices'])) {
            throw new \UnexpectedValueException('Response does not contain field \'educationServices\'!');
        }

        return array_map(function (array $educationService) {
            $educationServiceResponse = new GetStudentEducationServiceResponse();
            $educationServiceResponse->loadFromArray($educationService);

            $errors = $this->validator->validate($educationServiceResponse);
            if ($errors->count() > 0) {
                throw new \UnexpectedValueException(
                    'Errors in getStudentEducationServices api request ' . json_encode($errors),
                );
            }

            return $educationServiceResponse;
        }, $response['educationServices']);
    }

    public function getEducationService(int $educationServiceId): GetEducationServiceResponse
    {
        $result = (array)$this->get("/server-api/anti-corruption/v3/education-services/{$educationServiceId}/");

        $educationServiceResponse = new GetEducationServiceResponse();
        $educationServiceResponse->loadFromArray($result);

        $errors = $this->validator->validate($educationServiceResponse);
        if ($errors->count() > 0) {
            throw new \UnexpectedValueException('Errors in getEducationService api request ' . json_encode($errors));
        }

        return $educationServiceResponse;
    }

    /**
     * @return string[]|array|null
     */
    private function get(string $path): ?array
    {
        try {
            $response = $this->crm2ApiClient->get($path);

            return json_decode((string)$response->getBody(), true);
        } catch (\RuntimeException $e) {
            $this->logger->error($e->getMessage());

            throw $e;
        }
    }
}
