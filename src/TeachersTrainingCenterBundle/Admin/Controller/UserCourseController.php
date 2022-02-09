<?php

declare(strict_types=1);

namespace TeachersTrainingCenterBundle\Admin\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\Exporter\Source\CsvSourceIterator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use TeachersTrainingCenterBundle\Api\ContentApi\ContentApi;
use TeachersTrainingCenterBundle\Feature\UserCourse\Model\DTO\UserCourseCreateDTO;
use TeachersTrainingCenterBundle\Feature\UserCourse\Service\UserCourseManager;

class UserCourseController extends CRUDController
{
    private ContentApi $contentApi;

    private UserCourseManager $userCourseManager;

    public function __construct(ContentApi $contentApi, UserCourseManager $userCourseManager)
    {
        $this->contentApi = $contentApi;
        $this->userCourseManager = $userCourseManager;
    }

    public function showBatchAddFormAction(): Response
    {
        return $this->renderWithExtraParams('admin/userCourse/batch_action.html.twig', [
            'actionName' => 'Save',
            'actionFormUri' => $this->generateUrl('admin_app_usercourse_batchAdd'),
            'actionFileUri' => $this->generateUrl('admin_app_usercourse_csvImport'),
            'courses' => $this->contentApi->getCourseMap(),
        ]);
    }

    public function batchAddAction(Request $request): RedirectResponse
    {
        $userIdsString = $request->request->get('userIds');

        $userIds = array_filter(explode("\n", $userIdsString), static fn ($el) => is_numeric($el));
        $courseId = $request->request->get('courseId');

        if (!is_numeric($courseId)) {
            throw new BadRequestHttpException('Course id should be provided');
        }

        if (count($userIds) === 0) {
            throw new BadRequestHttpException('User ids should be provided');
        }

        $userCourseCreateDTOs = [];
        foreach ($userIds as $userId) {
            $existingUserCourse = $this->userCourseManager->findByUserAndCourse((int)$userId, (int)$courseId);
            if (!$existingUserCourse->isEmpty()) {
                continue;
            }

            $userCourseCreateDTOs[] = new UserCourseCreateDTO((int)$userId, (int)$courseId);
        }

        $this->userCourseManager->batchCreate($userCourseCreateDTOs);

        return $this->redirectToRoute('admin_app_usercourse_list');
    }

    public function showBatchDeleteFormAction(): Response
    {
        return $this->renderWithExtraParams('admin/userCourse/batch_action.html.twig', [
            'actionName' => 'Delete',
            'actionFormUri' => $this->generateUrl('admin_app_usercourse_batchDelete'),
            'actionFileUri' => $this->generateUrl('admin_app_usercourse_csvDelete'),
            'courses' => $this->contentApi->getCourseMap(),
        ]);
    }

    public function batchDeleteAction(Request $request): RedirectResponse
    {
        $userIdsString = $request->request->get('userIds');

        $userIds = array_filter(explode("\n", $userIdsString), static fn ($el) => is_numeric($el));
        $courseId = $request->request->get('courseId');

        if (!is_numeric($courseId)) {
            throw new BadRequestHttpException('Course id should be provided');
        }

        if (count($userIds) === 0) {
            throw new BadRequestHttpException('User ids should be provided');
        }

        $entitiesToDelete = [];
        foreach ($userIds as $userId) {
            $existingUserCourse = $this->userCourseManager->findByUserAndCourse((int)$userId, (int)$courseId);

            if ($existingUserCourse->isEmpty()) {
                continue;
            }

            foreach ($existingUserCourse as $course) {
                $entitiesToDelete[] = $course;
            }
        }

        $this->userCourseManager->batchDelete($entitiesToDelete);

        return $this->redirectToRoute('admin_app_usercourse_list');
    }

    public function csvImportAction(Request $request): RedirectResponse
    {
        // Метод обязательно нужно будет отрефакторить, как и весь этот контроллер в принципе

        $file = $request->files->get('csvFile');
        $filePath = $file->getRealPath();
        $iterator = new CsvSourceIterator($filePath);

        $userCourseCreateDTOs = [];
        foreach ($iterator as $item) {
            if (isset($item['userId'], $item['courseId'])) {
                $userId = $item['userId'];
                $courseId = $item['courseId'];

                $existingUserCourse = $this->userCourseManager->findByUserAndCourse((int)$userId, (int)$courseId);

                if (!$existingUserCourse->isEmpty()) {
                    continue;
                }

                $userCourseCreateDTOs[] = new UserCourseCreateDTO((int)$userId, $courseId);
            }
        }

        $this->userCourseManager->batchCreate($userCourseCreateDTOs);

        return $this->redirectToRoute('admin_app_usercourse_list');
    }

    public function csvDeleteAction(Request $request): RedirectResponse
    {
        // Метод обязательно нужно будет отрефакторить, как и весь этот контроллер в принципе

        $file = $request->files->get('csvFile');
        $filePath = $file->getRealPath();
        $iterator = new CsvSourceIterator($filePath);

        $userCourseToDelete = [];
        foreach ($iterator as $item) {
            if (isset($item['userId'], $item['courseId'])) {
                $userId = $item['userId'];
                $courseId = $item['courseId'];

                $existingUserCourse = $this->userCourseManager->findByUserAndCourse((int)$userId, (int)$courseId);

                if ($existingUserCourse->isEmpty()) {
                    continue;
                }

                foreach ($existingUserCourse as $course) {
                    $userCourseToDelete[] = $course;
                }
            }
        }

        $this->userCourseManager->batchDelete($userCourseToDelete);

        return $this->redirectToRoute('admin_app_usercourse_list');
    }
}
