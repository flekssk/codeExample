<?php

namespace App\UI\Controller;

use App\Application\HealthCheck\HealthCheckServiceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;

class HealthCheckController
{
    /** @var HealthCheckServiceInterface */
    private HealthCheckServiceInterface $service;

    /**
     * HealthCheckController constructor.
     * @param HealthCheckServiceInterface $service
     */
    public function __construct(HealthCheckServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * @SWG\Get(security={})
     * @SWG\Response(
     *     response=200,
     *     description="Health check",
     * )
     *
     * @Route("/_/status/", methods={"GET"})
     *
     * @return Response
     * @throws \App\Application\HealthCheck\Exception\HealthCheckErrorException
     */
    public function __invoke(): Response
    {
        $this->service->healthCheck();

        return new JsonResponse();
    }
}
