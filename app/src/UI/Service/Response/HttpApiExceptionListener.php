<?php

declare(strict_types=1);

namespace App\UI\Service\Response;

use App\Application\Exception\ValidationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use App\Domain\Repository\NotFoundException;
use DomainException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;
use Symfony\Component\OptionsResolver\Exception\UndefinedOptionsException;

class HttpApiExceptionListener
{
    /**
     * @param ExceptionEvent $event
     * @throws \Throwable
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($event->getRequest() instanceof Request) {
            if ($exception instanceof ValidationException) {
                $response = ResponseFactory::createErrorResponse(
                    $event->getRequest(),
                    $exception->getMessage(),
                    $exception->getErrors()
                );
            } elseif ($exception instanceof HttpException) {
                $response = ResponseFactory::createErrorResponse(
                    $event->getRequest(),
                    $exception->getMessage(),
                    [],
                    $exception->getStatusCode()
                );
            } elseif ($exception instanceof UniqueConstraintViolationException) {
                $response = ResponseFactory::createErrorResponse(
                    $event->getRequest(),
                    'Сущность с таким ID уже существует.',
                    [$exception->getMessage()],
                    405
                );
            } elseif ($exception instanceof InvalidOptionsException) {
                $response = ResponseFactory::createErrorResponse(
                    $event->getRequest(),
                    'Ошибка при валидации переданного параметра.',
                    [$exception->getMessage()],
                );
            } elseif ($exception instanceof MissingOptionsException) {
                $response = ResponseFactory::createErrorResponse(
                    $event->getRequest(),
                    'Не передан обязательный параметр.',
                    [$exception->getMessage()],
                );
            } elseif ($exception instanceof UndefinedOptionsException) {
                $response = ResponseFactory::createErrorResponse(
                    $event->getRequest(),
                    'Указанный параметр не существует.',
                    [$exception->getMessage()],
                );
            } elseif ($exception instanceof NotFoundException) {
                $response = ResponseFactory::createErrorResponse(
                    $event->getRequest(),
                    $exception->getMessage(),
                    [],
                    404
                );
            } elseif ($exception instanceof DomainException) {
                $response = ResponseFactory::createErrorResponse(
                    $event->getRequest(),
                    $exception->getMessage(),
                    [],
                    400
                );
            } else {
                throw $exception;
            }
        } else {
            throw $exception;
        }

        $event->setResponse($response);
    }
}
