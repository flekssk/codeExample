<?php

declare(strict_types=1);

namespace App\Application\Specialist\Specialist;

use App\Application\Specialist\Assembler\SpecialistResultAssemblerInterface;
use App\Application\Specialist\Dto\SpecialistResultDto;
use App\Application\Specialist\Specialist\Assembler\SpecialistUpdateAssemblerInterface;
use App\Application\Specialist\Specialist\Dto\SpecialistAddDto;
use App\Application\Exception\ValidationException;
use App\Application\Specialist\Specialist\Dto\SpecialistUpdateDto;
use App\Application\Specialist\Specialist\Resolver\SpecialistAddResolverInterface;
use App\Application\Specialist\Specialist\Resolver\SpecialistUpdateResolverInterface;
use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;
use App\Domain\Service\Specialist\SpecialistStatusCalcServiceInterface;

/**
 * Class SpecialistService.
 *
 * @package App\Application\Specialist\Specialist
 */
class SpecialistService
{
    /**
     * @var SpecialistRepositoryInterface
     */
    private SpecialistRepositoryInterface $specialistRepository;

    /**
     * @var SpecialistAddResolverInterface
     */
    private SpecialistAddResolverInterface $specialistAddResolver;

    /**
     * @var SpecialistUpdateResolverInterface
     */
    private SpecialistUpdateResolverInterface $specialistUpdateResolver;

    /**
     * @var SpecialistResultAssemblerInterface
     */
    private SpecialistResultAssemblerInterface $specialistResultAssembler;

    /**
     * @var SpecialistStatusCalcServiceInterface
     */
    private SpecialistStatusCalcServiceInterface $calcService;

    /**
     * @var SpecialistUpdateAssemblerInterface
     */
    private SpecialistUpdateAssemblerInterface $specialistUpdateAssembler;

    /**
     * SpecialistService constructor.
     * @param SpecialistRepositoryInterface $specialistRepository
     * @param SpecialistAddResolverInterface $specialistAddResolver
     * @param SpecialistUpdateResolverInterface $specialistUpdateResolver
     * @param SpecialistResultAssemblerInterface $specialistResultAssembler
     * @param SpecialistStatusCalcServiceInterface $calcService
     * @param SpecialistUpdateAssemblerInterface $specialistUpdateAssembler
     */
    public function __construct(
        SpecialistRepositoryInterface $specialistRepository,
        SpecialistAddResolverInterface $specialistAddResolver,
        SpecialistUpdateResolverInterface $specialistUpdateResolver,
        SpecialistResultAssemblerInterface $specialistResultAssembler,
        SpecialistStatusCalcServiceInterface $calcService,
        SpecialistUpdateAssemblerInterface $specialistUpdateAssembler
    ) {
        $this->specialistRepository = $specialistRepository;
        $this->specialistAddResolver = $specialistAddResolver;
        $this->specialistUpdateResolver = $specialistUpdateResolver;
        $this->specialistResultAssembler = $specialistResultAssembler;
        $this->calcService = $calcService;
        $this->specialistUpdateAssembler = $specialistUpdateAssembler;
    }

    /**
     * @param SpecialistAddDto $dto
     *
     * @return SpecialistResultDto
     *@throws ValidationException
     *
     */
    public function addOrUpdateSpecialist(SpecialistAddDto $dto): SpecialistResultDto
    {
        // Проверка на наличие уже существующего специалиста.
        // При наличии уже существующего специалиста - создать SpecialistUpdateDto и сохранить ее.
        $existingSpecialist = $this->specialistRepository->find($dto->id);
        if ($existingSpecialist) {
            $dto = $this->createUpdateDtoFromAddDto($dto);
            $specialist = $this->specialistUpdateResolver->resolve($dto);
        } else {
            $specialist = $this->specialistAddResolver->resolve($dto);
        }

        $this->specialistRepository->save($specialist);

        $this->calcService->calcStatus($specialist);

        return $this->specialistResultAssembler->assemble($specialist);
    }

    /**
     * @param SpecialistUpdateDto $dto
     *
     * @return SpecialistResultDto
     */
    public function updateSpecialist(SpecialistUpdateDto $dto): SpecialistResultDto
    {
        $specialist = $this->specialistUpdateResolver->resolve($dto);
        $this->specialistRepository->save($specialist);

        $this->calcService->calcStatus($specialist);

        return $this->specialistResultAssembler->assemble($specialist);
    }

    /**
     * Функция для создания SpecialistUpdateDto из SpecialistAddDto.
     *
     * @param SpecialistAddDto $dto
     *
     * @return SpecialistUpdateDto
     */
    private function createUpdateDtoFromAddDto(SpecialistAddDto $dto)
    {
        $options = [
            'id' => $dto->id,
        ];

        return $this->specialistUpdateAssembler->assemble($options);
    }
}
