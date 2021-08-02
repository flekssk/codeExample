<?php

declare(strict_types=1);

namespace App\Application\SiteOption;

use App\Application\SiteOption\Assembler\SiteOptionListResultAssemblerInterface;
use App\Application\SiteOption\Assembler\SiteOptionResultAssemblerInterface;
use App\Application\SiteOption\Dto\SiteOptionListResultDto;
use App\Application\SiteOption\Dto\SiteOptionResultDto;
use App\Domain\Repository\NotFoundException;
use App\Domain\Repository\SiteOptionRepositoryInterface;

/**
 * Class SiteOptionGetService.
 *
 * Сервис получения опций из таблицы option.
 *
 * @package App\Application\SiteOption
 */
class SiteOptionGetService
{
    /**
     * @var SiteOptionResultAssemblerInterface
     */
    private SiteOptionResultAssemblerInterface $siteOptionResultAssembler;

    /**
     * @var SiteOptionRepositoryInterface
     */
    private SiteOptionRepositoryInterface $siteOptionRepository;

    /**
     * @var SiteOptionListResultAssemblerInterface
     */
    private SiteOptionListResultAssemblerInterface $siteOptionListResultAssembler;

    /**
     * OptionGetService constructor.
     *
     * @param SiteOptionResultAssemblerInterface     $siteOptionResultAssembler
     * @param SiteOptionRepositoryInterface          $siteOptionRepository
     * @param SiteOptionListResultAssemblerInterface $siteOptionListResultAssembler
     */
    public function __construct(
        SiteOptionResultAssemblerInterface $siteOptionResultAssembler,
        SiteOptionRepositoryInterface $siteOptionRepository,
        SiteOptionListResultAssemblerInterface $siteOptionListResultAssembler
    ) {
        $this->siteOptionResultAssembler = $siteOptionResultAssembler;
        $this->siteOptionRepository = $siteOptionRepository;
        $this->siteOptionListResultAssembler = $siteOptionListResultAssembler;
    }

    /**
     * @param string $name
     *
     * @return SiteOptionResultDto
     */
    public function getByName(string $name): SiteOptionResultDto
    {
        $option = $this->siteOptionRepository->findOneByName($name);

        $dto = $this->siteOptionResultAssembler->assemble($option);

        return $dto;
    }

    /**
     * @param string[] $names
     *
     * @return array
     */
    public function findByNames(array $names): array
    {
        $options = [];

        foreach ($names as $name) {
            try {
                $options[] = $this->siteOptionResultAssembler->assemble($this->siteOptionRepository->findOneByName($name));
            } catch (NotFoundException $exception) {
            }
        }

        return $options;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $result = [];
        $options = $this->siteOptionRepository->findAllOptions();

        foreach ($options as $option) {
            $result[] = $this->siteOptionResultAssembler->assemble($option);
        }

        return $result;
    }
}
