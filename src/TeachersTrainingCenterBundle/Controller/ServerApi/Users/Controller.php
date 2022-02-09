<?php

namespace TeachersTrainingCenterBundle\Controller\ServerApi\Users;

use TeachersTrainingCenterBundle\Controller\ServerApi\Users\Input\AttachCoursesRequest;
use TeachersTrainingCenterBundle\Entity\Progress;
use TeachersTrainingCenterBundle\Service\ProgressService;
use TeachersTrainingCenterBundle\Service\UserCourseService;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\ConstraintViolationListInterface as ValidationErrors;

/**
 * @Rest\Route("/server-api/users")
 */
class Controller extends AbstractFOSRestController
{
    /**
     * @var UserCourseService
     */
    private $userCourseService;

    /**
     * @var ProgressService
     */
    private $progressService;

    public function __construct(UserCourseService $userCourseService, ProgressService $progressService)
    {
        $this->userCourseService = $userCourseService;
        $this->progressService = $progressService;
    }

    /**
     * @Rest\Post("/{userId}/courses")
     */
    public function attachCoursesAction(int $userId, Request $request)
    {
        $courseIds = json_decode($request->getContent(), true)['courseIds'] ?? null;

        if (empty($courseIds)) {
            throw new BadRequestHttpException('No course ids provided');
        }

        $this->userCourseService->attachCoursesToUser($userId, $courseIds);

        return new JsonResponse([
            'success' => true,
        ]);
    }

    /**
     * @Rest\Get("/{userId}/progress")
     */
    public function getCoursesProgressAction(int $userId, Request $request)
    {
        $courseIds = $request->query->get('courseIds', []);
        $progressItems = $this->progressService->getProgressForCoursesByUserId($userId, $courseIds);

        $progressItemsForResponse = array_values(
            array_map(function (Progress $progress) {
                return [
                    'courseId' => (int) $progress->getProgressId(),
                    'completeness' => $progress->getValue()['completeness'] ?? 0.0,
                ];
            }, $progressItems),
        );

        return new JsonResponse([
            'userId' => $userId,
            'progress' => $progressItemsForResponse,
        ]);
    }
}
