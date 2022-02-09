<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Feature\Course\Http\GetCourseList\Api;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use TeachersCommonBundle\Feature\ConventionalResponse\DTO\ConventionalApiResponseDTO;
use TeachersTrainingCenterBundle\Feature\Course\Http\GetCourseList\Api\Output\GetCourseListResponse;
use TeachersTrainingCenterBundle\Feature\Course\Service\CourseManager;

final class Controller
{
    private CourseManager $courseDAO;

    public function __construct(CourseManager $courseDAO)
    {
        $this->courseDAO = $courseDAO;
    }

    /**
     * @Route("/api/v1/course/list", methods={"POST"})
     *
     * @SWG\Tag(name="Course")
     * @SWG\Response(
     *     response=200,
     *     description="см. GetCourseListResponse",
     * @Model(type=GetCourseListResponse::class)
     * )
     */
    public function __invoke(): ConventionalApiResponseDTO
    {
        return GetCourseListResponse::successfulResult($this->courseDAO->findAll());
    }
}
