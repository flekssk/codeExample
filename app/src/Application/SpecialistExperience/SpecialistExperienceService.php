<?php

declare(strict_types=1);

namespace App\Application\SpecialistExperience;

use App\Domain\Repository\NotFoundException;
use App\Application\Exception\ValidationException;
use App\Application\SpecialistExperience\Assembler\SpecialistExperienceResultAssembler;
use App\Application\SpecialistExperience\Dto\SpecialistExperienceAddDto;
use App\Application\SpecialistExperience\Dto\SpecialistExperienceResultDto;
use App\Application\SpecialistExperience\Dto\SpecialistExperienceUpdateDto;
use App\Application\SpecialistExperience\Resolver\SpecialistExperienceAddResolverInterface;
use App\Application\SpecialistExperience\Resolver\SpecialistExperienceUpdateResolverInterface;
use App\Domain\Repository\SpecialistExperience\SpecialistExperienceRepositoryInterface;

/**
 * Class SpecialistExperienceService.
 *
 * @package App\Application\SpecialistExperience
 */
class SpecialistExperienceService
{
    /**
     * @var SpecialistExperienceAddResolverInterface
     */
    private SpecialistExperienceAddResolverInterface $specialistExperienceAddResolver;

    /**
     * @var SpecialistExperienceRepositoryInterface
     */
    private SpecialistExperienceRepositoryInterface $specialistExperienceRepository;

    /**
     * @var SpecialistExperienceResultAssembler
     */
    private SpecialistExperienceResultAssembler $specialistExperienceResultAssembler;

    /**
     * @var SpecialistExperienceUpdateResolverInterface
     */
    private SpecialistExperienceUpdateResolverInterface $specialistExperienceUpdateResolver;

    /**
     * SpecialistExperienceService constructor.
     *
     * @param SpecialistExperienceAddResolverInterface $specialistExperienceAddResolver
     * @param SpecialistExperienceUpdateResolverInterface $specialistExperienceUpdateResolver
     * @param SpecialistExperienceRepositoryInterface $specialistExperienceRepository
     * @param SpecialistExperienceResultAssembler $specialistExperienceResultAssembler
     */
    public function __construct(
        SpecialistExperienceAddResolverInterface $specialistExperienceAddResolver,
        SpecialistExperienceUpdateResolverInterface $specialistExperienceUpdateResolver,
        SpecialistExperienceRepositoryInterface $specialistExperienceRepository,
        SpecialistExperienceResultAssembler $specialistExperienceResultAssembler
    ) {
        $this->specialistExperienceAddResolver = $specialistExperienceAddResolver;
        $this->specialistExperienceUpdateResolver = $specialistExperienceUpdateResolver;
        $this->specialistExperienceRepository = $specialistExperienceRepository;
        $this->specialistExperienceResultAssembler = $specialistExperienceResultAssembler;
    }

    /**
     * @param SpecialistExperienceAddDto $dto
     *
     * @return SpecialistExperienceResultDto
     *
     * @throws ValidationException
     */
    public function addSpecialistExperience(SpecialistExperienceAddDto $dto): SpecialistExperienceResultDto
    {
        $experience = $this->specialistExperienceAddResolver->resolve($dto);
        $this->specialistExperienceRepository->save($experience);

        return $this->specialistExperienceResultAssembler->assemble($experience);
    }

    /**
     * @param SpecialistExperienceUpdateDto $dto
     *
     * @return SpecialistExperienceResultDto
     *
     * @throws ValidationException
     */
    public function updateSpecialistExperience(SpecialistExperienceUpdateDto $dto): SpecialistExperienceResultDto
    {
        $experience = $this->specialistExperienceUpdateResolver->resolve($dto);
        $this->specialistExperienceRepository->save($experience);

        return $this->specialistExperienceResultAssembler->assemble($experience);
    }

    /**
     * @param int $id
     *
     * @return bool
     *
     * @throws NotFoundException
     */
    public function deleteSpecialistExperience(int $id): bool
    {
        $experience = $this->specialistExperienceRepository->get($id);
        $this->specialistExperienceRepository->delete($experience);

        return true;
    }

    /**
     * @param int $id
     * @return SpecialistExperienceResultDto[]
     */
    public function getSpecialistExperience(int $id): array
    {
        $experienceDto = [];
        $experiences = $this->specialistExperienceRepository->findBySpecialistId($id);
        foreach ($experiences as $experience) {
            $experienceDto[] = $this->specialistExperienceResultAssembler->assemble($experience);
        }

        return $experienceDto;
    }
}
