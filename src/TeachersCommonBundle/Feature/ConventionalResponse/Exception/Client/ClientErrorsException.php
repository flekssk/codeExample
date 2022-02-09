<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ConventionalResponse\Exception\Client;

use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalResponseErrorDTO;
use TeachersCommonBundle\Feature\ConventionalResponse\Exception\ErrorsExceptionInterface;

final class ClientErrorsException extends \Exception implements ErrorsExceptionInterface
{
    /**
     * @var ConventionalResponseErrorDTO[]
     */
    private array $errors;

    /**
     * @param ConventionalResponseErrorDTO[] $errors
     */
    public function __construct(array $errors, string $methodUri, string $serviceName)
    {
        $this->errors = $errors;

        $message = $this->buildMessage($errors, $methodUri, $serviceName);

        parent::__construct($message);
    }

    /**
     * @return ConventionalResponseErrorDTO[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param ConventionalResponseErrorDTO[] $errors
     */
    private function buildMessage(array $errors, string $methodUri, string $serviceName): string
    {
        $errorMessage = sprintf("%s API method [%s] returned errors: \n", $serviceName, $methodUri);

        foreach ($errors as $error) {
            $errorMessage .= sprintf(
                "Property %s - (%s) %s, \n",
                $error->property(),
                $error->error()->code(),
                $error->error()->message()
            );
        }

        return $errorMessage;
    }
}
