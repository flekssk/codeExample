<?php

declare(strict_types=1);

namespace App\UI\Service\Response;

use SplFileInfo;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Mime\MimeTypes;

class ResponseFactory
{
    /**
     * @param Request $request
     * @param string $message
     * @param mixed $data
     * @param int $code
     * @return Response
     */
    public static function createOkResponse(
        Request $request,
        $data = [],
        string $message = '',
        int $code = Response::HTTP_OK
    ): Response {
        $formats = $request->headers->get('content-type');

        switch ($formats) {
            default:
                $response = static::createJsonResponse([
                    'message' => $message,
                    'data' => [
                        'result' => $data,
                    ],
                ], $code);
        }

        return $response;
    }

    /**
     * @param Request $request
     * @param array   $data ,
     * @param int     $page ,
     * @param int     $perPage ,
     * @param int     $totalCount
     * @param string  $message
     * @param int     $code
     *
     * @return Response
     */
    public static function createPaginatedOkResponse(
        Request $request,
        array $data = [],
        int $page = 1,
        int $perPage = 1,
        int $totalCount = 1,
        string $message = '',
        int $code = Response::HTTP_OK
    ): Response {
        $formats = $request->headers->get('content-type');

        switch ($formats) {
            default:
                $response = static::createJsonResponse(
                    [
                        'message' => $message,
                        'data' => [
                            'result' => $data,
                            'page' => $page,
                            'perPage' => $perPage,
                            'totalCount' => $totalCount
                        ],
                    ],
                    $code
                );
        }

        return $response;
    }

    /**
     * @param Request $request
     * @param string $message
     * @param array $errors
     * @param int $code
     * @return Response
     */
    public static function createErrorResponse(
        Request $request,
        string $message = '',
        array $errors = [],
        int $code = Response::HTTP_BAD_REQUEST
    ): Response {
        $formats = $request->headers->get('content-type');

        switch ($formats) {
            default:
                $response = static::createJsonResponse([
                    'message' => $message,
                    'errors' => $errors,
                ], $code);
        }

        return $response;
    }

    /**
     * @param Request $request
     * @param string $message
     * @param string $exceptionMessage
     * @param \Throwable $exception
     * @param int $code
     * @return Response
     */
    public static function createExceptionResponse(
        Request $request,
        string $message,
        string $exceptionMessage,
        ?\Throwable $exception = null,
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR
    ): Response {
        $formats = $request->headers->get('content-type');

        switch ($formats) {
            default:
                $data = [
                    'message' => $message,
                    'exceptionMessage' => $exceptionMessage,
                ];
                if (null !== $exception) {
                    $data['exceptionType'] = get_class($exception);
                    $data['stackTrace'] = $exception->getTrace();
                }
                $response = static::createJsonResponse($data, $code);
        }

        return $response;
    }

    /**
     * @param mixed $data
     * @param int $code
     * @return JsonResponse
     */
    protected static function createJsonResponse(
        $data,
        int $code
    ): JsonResponse {
        return new JsonResponse($data, $code);
    }

    /**
     * @param SplFileInfo $file
     * @param bool $deleteAfterSend
     * @return Response
     */
    public static function createFileResponse(SplFileInfo $file, bool $deleteAfterSend = false): Response
    {
        $response = new BinaryFileResponse($file);

        $mimeType = new MimeTypes();
        $mimeTypes = $mimeType->getMimeTypes($file->getExtension());
        $mimeTypeValue = empty($mimeTypes) ? $mimeType->guessMimeType($file->getPathname()) ?? 'application/octet-stream' : $mimeTypes[0];
        $response->headers->set('Content-Type', $mimeTypeValue);

        $fileNameSanitized = str_replace(['/', '\\'], '_', $file->getFilename());
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $fileNameSanitized);
        $response->setCharset('utf8');
        $response->deleteFileAfterSend($deleteAfterSend);

        return $response;
    }
}
