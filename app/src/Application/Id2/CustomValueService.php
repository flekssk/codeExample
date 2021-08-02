<?php

declare(strict_types=1);

namespace App\Application\Id2;

use App\Application\Id2\Assembler\CustomValueAssembler;
use App\Application\Id2\Dto\CustomValueDto;
use App\Domain\Entity\Event\CustomValue;
use App\Domain\Repository\Id2\CustomValueRepositoryInterface;

/**
 * Class CustomValueService.
 *
 * @package App\Application\CustomValue
 */
class CustomValueService
{
    /**
     * @var CustomValueRepositoryInterface
     */
    private CustomValueRepositoryInterface $repository;

    /**
     * @var CustomValueAssembler
     */
    private CustomValueAssembler $assembler;

    /**
     * CustomValueService constructor.
     *
     * @param CustomValueRepositoryInterface $repository
     * @param CustomValueAssembler $assembler
     */
    public function __construct(
        CustomValueRepositoryInterface $repository,
        CustomValueAssembler $assembler
    ) {
        $this->repository = $repository;
        $this->assembler = $assembler;
    }

    /**
     * @param string[] $names
     * @return CustomValueDto[]
     */
    public function searchCustomValues(array $names): array
    {
        $customValuesDto = [];
        $customValues = $this->repository->findAllEvents();
        foreach ($customValues as $customValue) {
            if ($names === [] || in_array($customValue->getName(), $names)) {
                $customValuesDto[] = $this->assembler->assemble($customValue);
            }
        }

        return $customValuesDto;
    }
}
