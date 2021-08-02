<?php

namespace App\UI\Controller\EasyAdmin;

use App\Application\SpecialistDocument\SpecialistDocumentService;
use EasyCorp\Bundle\EasyAdminBundle\Controller\EasyAdminController;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class SpecialistController.
 *
 * @package App\UI\Controller\EasyAdmin
 */
class AdminSpecialistController extends EasyAdminController
{
    /**
     * @var SpecialistDocumentService
     */
    private SpecialistDocumentService $specialistDocumentService;

    public function __construct(SpecialistDocumentService $specialistDocumentService)
    {
        $this->specialistDocumentService = $specialistDocumentService;
    }

    /**
     * @return RedirectResponse
     *
     * @throws Exception
     */
    public function updateDocumentsAction(): RedirectResponse
    {
        $id = $this->request->query->get('id');

        $this->specialistDocumentService->updateForSpecialistId((int) $id);

        return $this->redirectToRoute('easyadmin', [
            'action' => 'show',
            'id' => $id,
            'entity' => $this->request->query->get('entity'),
        ]);
    }
}
