<?php

declare(strict_types=1);

namespace App\Application\Specialist\SpecialistAutocomplete;

use App\Application\Specialist\Assembler\SpecialistAutocompleteDisplayAssemblerInterface;
use App\Infrastructure\Persistence\Sphinx\Repository\Specialist\Dto\SpecialistFindDto;
use App\Infrastructure\Repository\Specialist\SpecialistSearchRepositoryInterface;

/**
 * Class SpecialistAutocompleteService.
 *
 * Сервис autocomplete для поиска пользователей.
 *
 * @package App\Application\Specialist\SpecialistAutocompleteService
 */
class SpecialistAutocompleteService
{

    /**
     * @var SpecialistSearchRepositoryInterface
     */
    private SpecialistSearchRepositoryInterface $repository;

    /**
     * @var SpecialistAutocompleteDisplayAssemblerInterface
     */
    private SpecialistAutocompleteDisplayAssemblerInterface $assembler;

    /**
     * SpecialistAutocompleteService constructor.
     *
     * @param SpecialistSearchRepositoryInterface $repository
     * @param SpecialistAutocompleteDisplayAssemblerInterface $assembler
     */
    public function __construct(
        SpecialistSearchRepositoryInterface $repository,
        SpecialistAutocompleteDisplayAssemblerInterface $assembler
    ) {
        $this->repository = $repository;
        $this->assembler = $assembler;
    }

    /**
     * @param SpecialistFindDto $findDto
     * @param int $limit
     *
     * @return array
     */
    public function find(SpecialistFindDto $findDto, int $limit = 50): array
    {
        $result = [];

        $specialists = $this->repository->findBy($findDto, null, $limit, 0);

        foreach ($specialists as $specialist) {
            $result[] = $this->assembler->assemble($specialist);
        }

        return $result;
    }
}
