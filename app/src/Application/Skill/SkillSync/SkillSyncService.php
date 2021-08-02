<?php

namespace App\Application\Skill\SkillSync;

use App\Application\Skill\SkillSync\Resolver\SkillSyncResolverInterface;
use App\Domain\Repository\SiteOptionRepositoryInterface;
use App\Domain\Repository\Skill\SkillRepositoryInterface;
use App\Infrastructure\HttpClients\Skills\Dto\SkillsResponseDto;
use App\Infrastructure\HttpClients\Skills\SkillsService;

/**
 * Class SkillGetService.
 *
 * @package App\Application\Skill
 */
class SkillSyncService implements SkillSyncServiceInterface
{
    /**
     * @var SkillsService
     */
    private SkillsService $skillsService;

    /**
     * @var SkillRepositoryInterface
     */
    private SkillRepositoryInterface $skillRepository;

    /**
     * @var SkillSyncResolverInterface
     */
    private SkillSyncResolverInterface $skillSyncResolver;

    /**
     * @var SiteOptionRepositoryInterface
     */
    private SiteOptionRepositoryInterface $siteOptionRepository;


    /**
     * SkillSyncService constructor.
     *
     * @param SkillsService $skillsService
     * @param SkillRepositoryInterface $skillRepository
     * @param SkillSyncResolverInterface $skillSyncResolver
     * @param SiteOptionRepositoryInterface $siteOptionRepository
     */
    public function __construct(
        SkillsService $skillsService,
        SkillRepositoryInterface $skillRepository,
        SkillSyncResolverInterface $skillSyncResolver,
        SiteOptionRepositoryInterface $siteOptionRepository
    ) {
        $this->skillsService = $skillsService;
        $this->skillRepository = $skillRepository;
        $this->skillSyncResolver = $skillSyncResolver;
        $this->siteOptionRepository = $siteOptionRepository;
    }

    /**
     * @inheritDoc
     */
    public function sync(): int
    {
        $processedCount = 0;

        $guid = $this->siteOptionRepository->findOneByName('skillsGuid')->getValue();
        if ($guid) {
            $skills = $this->skillsService->getByRegistryId($guid);

            /** @var SkillsResponseDto $skill */
            foreach ($skills as $skill) {
                $skillEntity = $this->skillSyncResolver->resolve($skill);

                $this->skillRepository->replace($skillEntity);
            }

            $processedCount = count($skills);
        }

        return $processedCount;
    }
}
