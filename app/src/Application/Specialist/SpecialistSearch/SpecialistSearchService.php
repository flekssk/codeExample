<?php

declare(strict_types=1);

namespace App\Application\Specialist\SpecialistSearch;

use App\Application\Specialist\Assembler\SpecialistPaginatedListResultAssemblerInterface;
use App\Application\Specialist\Dto\SpecialistPaginatedListResultDto;
use App\Application\SpecialistDocument\SpecialistDocumentService;
use App\Infrastructure\Persistence\Sphinx\Repository\Specialist\Dto\SpecialistFindDto;
use App\Infrastructure\Repository\Specialist\SpecialistSearchRepositoryInterface;

/**
 * Class SpecialistSearchService.
 *
 * Сервис поиска специалистов в sphinx.
 *
 * @package App\Application\Specialist\SpecialistFind
 */
class SpecialistSearchService
{
    /**
     * @var SpecialistSearchRepositoryInterface
     */
    private SpecialistSearchRepositoryInterface $specialistSearchRepository;

    /**
     * @var SpecialistPaginatedListResultAssemblerInterface
     */
    private SpecialistPaginatedListResultAssemblerInterface $specialistPaginatedListResultAssembler;

    /**
     * @var SpecialistDocumentService
     */
    private SpecialistDocumentService $documentService;

    /**
     * SpecialistFindService constructor.
     *
     * @param SpecialistSearchRepositoryInterface             $specialistSearchRepository
     * @param SpecialistPaginatedListResultAssemblerInterface $specialistPaginatedListResultAssembler
     * @param SpecialistDocumentService                       $documentService
     */
    public function __construct(
        SpecialistSearchRepositoryInterface $specialistSearchRepository,
        SpecialistPaginatedListResultAssemblerInterface $specialistPaginatedListResultAssembler,
        SpecialistDocumentService $documentService
    ) {
        $this->specialistSearchRepository = $specialistSearchRepository;
        $this->specialistPaginatedListResultAssembler = $specialistPaginatedListResultAssembler;
        $this->documentService = $documentService;
    }

    /**
     *
     * @param SpecialistFindDto $findDto
     *
     * @param int               $limit
     * @param int               $offset
     *
     * @return SpecialistPaginatedListResultDto
     */
    public function find(
        SpecialistFindDto $findDto,
        int $limit = 20,
        int $offset = 1
    ): SpecialistPaginatedListResultDto {
        $specialists = $this->specialistSearchRepository->findBy($findDto, 'status_id', $limit, $offset);

        $page = (int) (($offset + $limit) / $limit);
        $totalCount = $this->specialistSearchRepository->findResultsTotalCount($findDto);

        $result = $this->specialistPaginatedListResultAssembler->assemble($specialists, $page, $limit, $totalCount);

        foreach ($result->specialists as $specialist) {
            $specialist->document = $this->documentService->getLastDocumentBySpecialistId($specialist->id);
        }

        return $result;
    }
}
