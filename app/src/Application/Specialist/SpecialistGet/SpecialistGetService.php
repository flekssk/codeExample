<?php

namespace App\Application\Specialist\SpecialistGet;

use App\Application\Specialist\Assembler\SpecialistResultAssemblerInterface;
use App\Application\Specialist\Assembler\SpecialistResultFromId2AssemblerInterface;
use App\Application\Specialist\Dto\SpecialistResultDto;
use App\Application\SpecialistDocument\SpecialistDocumentService;
use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;
use App\Infrastructure\HttpClients\Id2\Id2UserServiceInterface;

/**
 * Class SpecialistGetService.
 *
 * @package App\Application\Specialist\SpecialistGet
 */
class SpecialistGetService
{
    /**
     * @var SpecialistRepositoryInterface
     */
    private SpecialistRepositoryInterface $specialistRepository;

    /**
     * @var SpecialistResultAssemblerInterface
     */
    private SpecialistResultAssemblerInterface $specialistResultAssembler;

    /**
     * @var Id2UserServiceInterface
     */
    private Id2UserServiceInterface $id2UserService;

    /**
     * @var SpecialistResultFromId2AssemblerInterface
     */
    private SpecialistResultFromId2AssemblerInterface $specialistResultFromId2Assembler;

    /**
     * @var SpecialistDocumentService
     */
    private SpecialistDocumentService $documentService;

    /**
     * SpecialistGetService constructor.
     * @param SpecialistRepositoryInterface $specialistRepository
     * @param SpecialistResultAssemblerInterface $specialistResultAssembler
     * @param Id2UserServiceInterface $id2UserService
     * @param SpecialistDocumentService $documentService
     * @param SpecialistResultFromId2AssemblerInterface $specialistResultFromId2Assembler
     */
    public function __construct(
        SpecialistRepositoryInterface $specialistRepository,
        SpecialistResultAssemblerInterface $specialistResultAssembler,
        Id2UserServiceInterface $id2UserService,
        SpecialistDocumentService $documentService,
        SpecialistResultFromId2AssemblerInterface $specialistResultFromId2Assembler
    ) {
        $this->id2UserService = $id2UserService;
        $this->specialistRepository = $specialistRepository;
        $this->specialistResultAssembler = $specialistResultAssembler;
        $this->documentService = $documentService;
        $this->specialistResultFromId2Assembler = $specialistResultFromId2Assembler;
    }

    /**
     * @param int $id
     *
     * @return SpecialistResultDto
     */
    public function get(int $id): SpecialistResultDto
    {
        if ($this->specialistRepository->has($id)) {
            $specialist = $this->specialistRepository->get($id);
            $dto = $this->specialistResultAssembler->assemble($specialist);
        } else {
            $id2User = $this->id2UserService->getUserById($id);
            $dto = $this->specialistResultFromId2Assembler->assemble($id2User);
        }
        $dto->document = $this->documentService->getLastDocumentBySpecialistId($dto->id);

        return $dto;
    }
}
