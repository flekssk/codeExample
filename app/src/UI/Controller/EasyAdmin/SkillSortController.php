<?php

namespace App\UI\Controller\EasyAdmin;

use App\Application\Skill\SkillGet\SkillGetServiceInterface;
use App\Application\Skill\SkillSort\Assembler\SkillSortAssemblerInterface;
use App\Application\Skill\SkillSort\SkillSortServiceInterface;
use App\Domain\Repository\NotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class SkillSortController.
 *
 * @package App\UI\Controller\EasyAdmin
 */
class SkillSortController extends AbstractController
{
    /**
     * @var SkillGetServiceInterface
     */
    private SkillGetServiceInterface $skillGetService;

    /**
     * @var SkillSortServiceInterface
     */
    private SkillSortServiceInterface $skillSortService;

    /**
     * @var SkillSortAssemblerInterface
     */
    private SkillSortAssemblerInterface $skillSortAssembler;

    /**
     * SkillSortController constructor.
     *
     * @param SkillGetServiceInterface $skillGetService
     * @param SkillSortServiceInterface $skillSortService
     * @param SkillSortAssemblerInterface $skillSortMacroSkillAssembler
     */
    public function __construct(
        SkillGetServiceInterface $skillGetService,
        SkillSortServiceInterface $skillSortService,
        SkillSortAssemblerInterface $skillSortMacroSkillAssembler
    ) {
        $this->skillGetService = $skillGetService;
        $this->skillSortService = $skillSortService;
        $this->skillSortAssembler = $skillSortMacroSkillAssembler;
    }

    /**
     * @Route("/admin/macro-skill-sort", name="macro_skill_sort")
     *
     * @param Request $request
     * @return Response
     */
    public function macroSkillSortList(Request $request): Response
    {
        $data = [
            'skills' => $this->skillGetService->getAllMacroSkills()
        ];

        return $this->render('easy_admin_macro_skill_sort.html.twig', $data);
    }

    /**
     * @Route("/admin/macro-skill-sort/save", name="macro_skill_sort_save", methods={"POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function macroSkillSortSave(Request $request): Response
    {
        $response = [
            'status' => 'success',
            'message' => '',
        ];
        $errors = [];

        $requestData = $request->request->all();

        foreach ($requestData as $item) {
            $dto = $this->skillSortAssembler->assemble($item);
            try {
                $this->skillSortService->saveMacroSkills($dto);
            } catch (NotFoundException $e) {
                $errors[] = $e->getMessage();
            }
        }

        if (!empty($errors)) {
            $response['status'] = 'error';
            $response['message'] = implode(PHP_EOL, $errors);
        }

        return $this->json($response);
    }


    /**
     * @Route("/admin/skill-sort", name="skill_sort")
     *
     * @param Request $request
     * @return Response
     */
    public function skillSortList(Request $request): Response
    {
        $data = [
            'skills' => $this->skillGetService->getAllSortedByMacroSkills()
        ];

        return $this->render('easy_admin_skill_sort.html.twig', $data);
    }

    /**
     * @Route("/admin/skill-sort/save", name="skill_sort_save", methods={"POST"})
     *
     * @param Request $request
     * @return Response
     */
    public function skillSortSave(Request $request): Response
    {
        $response = [
            'status' => 'success',
            'message' => '',
        ];
        $errors = [];

        $requestData = $request->request->all();

        foreach ($requestData as $item) {
            $dto = $this->skillSortAssembler->assemble($item);
            try {
                $this->skillSortService->saveSkills($dto);
            } catch (NotFoundException $e) {
                $errors[] = $e->getMessage();
            }
        }

        if (!empty($errors)) {
            $response['status'] = 'error';
            $response['message'] = implode(PHP_EOL, $errors);
        }

        return $this->json($response);
    }
}
