<?php

declare(strict_types=1);

namespace TeachersCommonBundle\Feature\ConventionalResponse\EventListener;

use JMS\Serializer\SerializerInterface;
use Skyeng\LogBundle\SimpleLoggerAwareTrait;
use Skyeng\LogBundle\Symfony\Server2ServerRequestProcessorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalApiResponseDTO;
use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalResponseErrorDetailsDTO;
use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalResponseErrorDTO;
use TeachersCommonBundle\Feature\ConventionalResponse\Exception\ConventionalResponseExceptionInterface;
use TeachersCommonBundle\Feature\ConventionalResponse\Exception\ErrorsExceptionInterface;
use TeachersCommonBundle\Feature\ConventionalResponse\Exception\TeachersCommonException;
use TeachersCommonBundle\Feature\ConventionalResponse\Exception\ValidationException;

/**
 * @see https://confluence.skyeng.ru/pages/viewpage.action?pageId=25396874
 */
class ConventionalApiExceptionListener
{
    use SimpleLoggerAwareTrait;

    protected string $channel = Server2ServerRequestProcessorInterface::LOG_CHANNEL;

    private KernelInterface $kernel;

    private SerializerInterface $serializer;

    public function __construct(KernelInterface $kernel, SerializerInterface $serializer)
    {
        $this->kernel = $kernel;
        $this->serializer = $serializer;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        if (!$this->shouldProcessEvent($event)) {
            return;
        }

        $env = $this->kernel->getEnvironment();
        $exception = $event->getThrowable();

        switch (true) {
            case $exception instanceof TeachersCommonException:
                $code = HttpResponse::HTTP_OK;
                $errors = [
                    $this->generateErrorForMessage(
                        null,
                        $exception->getMessage(),
                        ConventionalResponseErrorDetailsDTO::CODE_DOMAIN_ERROR
                    ),
                ];

                break;
            case $exception instanceof ConventionalResponseExceptionInterface:
                $code = HttpResponse::HTTP_OK;
                $errors = [
                    $this->generateErrorForMessage(
                        $exception->getProperty(),
                        $exception->getMessage(),
                        $exception->getConventionalCode(),
                        $exception->getExtra()
                    ),
                ];

                break;
            case $exception instanceof ValidationException:
                $code = HttpResponse::HTTP_OK;
                $errors = $this->generateErrorsForViolations($exception->violationList());

                break;
            case $exception instanceof HttpExceptionInterface:
                $code = $exception->getStatusCode();
                $errors = [
                    $this->generateErrorForMessage(
                        null,
                        $exception->getMessage(),
                        null
                    ),
                ];

                break;
            case $exception instanceof ErrorsExceptionInterface:
                $code = HttpResponse::HTTP_OK;
                $errors = $exception->getErrors();

                break;
            default:
                $code = HttpResponse::HTTP_INTERNAL_SERVER_ERROR;
                $message = $env === 'prod'
                    ? 'Internal error, try again later.'
                    : $exception->getMessage() . \PHP_EOL . $exception->getTraceAsString();

                $errors = [
                    $this->generateErrorForMessage(
                        null,
                        $message,
                        ConventionalResponseErrorDetailsDTO::CODE_INTERNAL_ERROR
                    ),
                ];

                $this->logger->emergency($exception);
        }

        $response = new JsonResponse(
            $this->serializer->serialize(
                ConventionalApiResponseDTO::errorResult(...$errors),
                'json'
            ),
            $code,
            [],
            true
        );
        $response->setStatusCode($code);

        $event->allowCustomResponseCode();
        $event->setResponse($response);
    }

    public function shouldProcessEvent(ExceptionEvent $event): bool
    {
        $uri = $event->getRequest()->getPathInfo();

        return strpos($uri, '/server-api/') === 0 || strpos($uri, '/api/') === 0;
    }

    private function generateErrorForMessage(
        ?string $property,
        string $message,
        ?string $code,
        ?\stdClass $extra = null
    ): ConventionalResponseErrorDTO {
        return new ConventionalResponseErrorDTO(
            $property,
            new ConventionalResponseErrorDetailsDTO($message, $code, $extra)
        );
    }

    /**
     * @return ConventionalResponseErrorDTO[]
     */
    private function generateErrorsForViolations(ConstraintViolationListInterface $violationList): array
    {
        $errors = [];

        foreach ($violationList as $violation) {
            /** @var ConstraintViolationInterface $violation */
            $propertyPath = (string)$violation->getPropertyPath();
            $errorKey = $propertyPath !== '' ? $propertyPath : null;

            // Здесь мы используем код не из Violation, так как после Symfony Validator'а
            // он не дает там полезной информации. Будем заменять его на наш код not_valid
            $details = new ConventionalResponseErrorDetailsDTO(
                $violation->getMessage(),
                ConventionalResponseErrorDetailsDTO::CODE_NOT_VALID
            );
            $errors[] = new ConventionalResponseErrorDTO($errorKey, $details);
        }

        return $errors;
    }
}
