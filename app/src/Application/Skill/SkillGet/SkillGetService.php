<?php

namespace App\Application\Skill\SkillGet;

use App\Application\Skill\SkillGet\Assembler\SkillResultAssemblerInterface;
use App\Domain\Entity\Skill\Skill;
use App\Domain\Repository\NotFoundException;
use App\Domain\Repository\SiteOptionRepositoryInterface;
use App\Domain\Repository\Skill\SkillRepositoryInterface;
use App\Domain\Repository\SkillImproveLink\SkillImproveLinkRepositoryInterface;
use App\Domain\Repository\Specialist\SpecialistRepositoryInterface;
use App\Infrastructure\HttpClients\Skills\SkillsClientInterface;
use GuzzleHttp\Exception\RequestException;

/**
 * Class SkillGetService.
 *
 * @package App\Application\Skill\SkillGet
 */
class SkillGetService implements SkillGetServiceInterface
{
    private const KEY_SKILL_MACRO_TYPE_NAME = 'Ключевые навыки';
    private const PROFESSIONAL_GROW_SKILL_MACRO_TYPE_NAME = 'Профессиональный рост';

    /**
     * ID ключевых навыков.
     *
     * @var string|null
     */
    private ?string $keySkillsId;

    /**
     * ID профессиональных навыков.
     *
     * @var string|null
     */
    private ?string $professionalGrowSkillsId;

    /**
     * Скрывать нулевые навыки
     *
     * @var bool
     */
    private bool $hideEmptySkills;

    /**
     * @var SkillResultAssemblerInterface
     */
    private SkillResultAssemblerInterface $skillResultAssembler;

    /**
     * @var SkillRepositoryInterface
     */
    private SkillRepositoryInterface $skillRepository;

    /**
     * @var SkillsClientInterface
     */
    private SkillsClientInterface $skillsClient;

    /**
     * @var SiteOptionRepositoryInterface
     */
    private SiteOptionRepositoryInterface $siteOptionRepository;

    /**
     * @var SpecialistRepositoryInterface
     */
    private SpecialistRepositoryInterface $specialistRepository;

    /**
     * @var SkillImproveLinkRepositoryInterface
     */
    private SkillImproveLinkRepositoryInterface $skillImproveLinkRepository;


    /**
     * SkillGetService constructor.
     *
     * @param SkillResultAssemblerInterface $skillResultAssembler
     * @param SkillRepositoryInterface $skillRepository
     * @param SkillsClientInterface $skillsClient
     * @param SiteOptionRepositoryInterface $siteOptionRepository
     * @param SpecialistRepositoryInterface $specialistRepository
     * @param SkillImproveLinkRepositoryInterface $skillImproveLinkRepository
     */
    public function __construct(
        SkillResultAssemblerInterface $skillResultAssembler,
        SkillRepositoryInterface $skillRepository,
        SkillsClientInterface $skillsClient,
        SiteOptionRepositoryInterface $siteOptionRepository,
        SpecialistRepositoryInterface $specialistRepository,
        SkillImproveLinkRepositoryInterface $skillImproveLinkRepository
    ) {
        $this->skillResultAssembler = $skillResultAssembler;
        $this->skillRepository = $skillRepository;
        $this->skillsClient = $skillsClient;
        $this->siteOptionRepository = $siteOptionRepository;
        $this->specialistRepository = $specialistRepository;
        $this->skillImproveLinkRepository = $skillImproveLinkRepository;

        $keySkill = $skillRepository->findOneBy(['macroTypeName' => self::KEY_SKILL_MACRO_TYPE_NAME]);
        $professionalGrowSkill = $skillRepository->findOneBy(['macroTypeName' => self::PROFESSIONAL_GROW_SKILL_MACRO_TYPE_NAME]);
        $this->keySkillsId = $keySkill ? $keySkill->getMacroTypeId() : null;
        $this->professionalGrowSkillsId = $professionalGrowSkill ? $professionalGrowSkill->getMacroTypeId() : null;
        try {
            $this->hideEmptySkills = (bool)$siteOptionRepository->findOneByName('hideEmptySkills')->getValue();
        } catch (NotFoundException $exception) {
            $this->hideEmptySkills = false;
        }
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        $skills = $this->skillRepository->findBy(['macroSkillId' => null]);

        $skillsResultList = [];

        foreach ($skills as $skill) {
            $skillsResultList[] = $this->skillResultAssembler->assemble($skill);
        }

        return $skillsResultList;
    }

    /**
     * @inheritDoc
     */
    public function getAllMacroSkills(): array
    {
        $result = [];

        $macroSkills = $this->skillRepository->getMacroSkills();

        foreach ($macroSkills as $macroSkill) {
            $macroTypeName = $macroSkill['macroTypeName'];
            $result[$macroTypeName]['name'] = $macroTypeName;
            $result[$macroTypeName]['elements'][] = $macroSkill;
        }

        return $result;
    }

    /**
     * @inheritDoc
     */
    public function getAllSortedByMacroSkills(): array
    {
        $result = [];

        $macroSkills = $this->skillRepository->getMacroSkills();

        foreach ($macroSkills as $macroSkill) {
            $macroTypeName = $macroSkill['macroTypeName'];
            $macroSkillId = $macroSkill['macroSkillId'];
            $skills = $this->skillRepository->getAllSkillsByMacroSkillId($macroSkillId);
            $result[$macroTypeName]['name'] = $macroTypeName;
            $result[$macroTypeName]['macroElements'][$macroSkillId]['name'] = $macroSkill['macroSkillName'];
            $result[$macroTypeName]['macroElements'][$macroSkillId]['elements'] = $skills;
        }

        return $result;
    }

    /**
     * @inheritDoc
     *
     * @throws RequestException
     */
    public function getBySpecialistId(int $id): array
    {
        $user = $this->specialistRepository->find($id);

        if (!$user) {
            throw new NotFoundException("Специалист с ID={$id} не найден.");
        }

        $userSkills = $this->skillsClient->getByUserId($id);
        $skills = $formattedUserSkills = $this->formatUserSkills($userSkills);

        if (!$this->hideEmptySkills) {
            $availableSkills = $this->skillRepository->getSkillsWithMacroSkillId();
            $skills = $this->mergeSkills($availableSkills, $formattedUserSkills);
        }

        $skills = $this->sortSkills($skills);
        $skillsWithDescriptions = $this->addDescriptionText($skills);
        return $this->cleanUp($skillsWithDescriptions);
    }

    /**
     * @inheritDoc
     *
     * @throws RequestException
     */
    public function getKeySkillsAveragePercentageBySpecialistId(int $id): float
    {
        $user = $this->specialistRepository->find($id);

        if (!$user) {
            throw new NotFoundException("Специалист с ID={$id} не найден.");
        }

        $userSkills = $this->getBySpecialistId($id);

        $keySkillsCount = 0;
        $keySkillsPercentSum = 0;
        $keySkillsPercentAverage = 0;

        foreach ($userSkills as $userSkillMacroGroup) {
            if ($userSkillMacroGroup['name'] == self::KEY_SKILL_MACRO_TYPE_NAME) {
                foreach ($userSkillMacroGroup['macros'] as $macro) {
                    foreach ($macro['skills'] as $skill) {
                        $keySkillsCount++;
                        $keySkillsPercentSum += $skill['percent'];
                    }
                }
            }
        }

        if ($keySkillsCount && $keySkillsPercentSum) {
            $keySkillsPercentAverage = $keySkillsPercentSum / $keySkillsCount;
        }

        if ($keySkillsPercentAverage != 0 && $keySkillsPercentAverage < 0.6) {
            $keySkillsPercentAverage = 0.6;
        }

        return round($keySkillsPercentAverage, 2);
    }

    /**
     * @param \stdClass[] $allUserSkills
     *
     * @return array
     */
    private function formatUserSkills(array $allUserSkills): array
    {
        $groupedByMacroTypeId = [];
        $guid = $this->siteOptionRepository->findOneByName('skillsGuid');

        if ($guid) {
            foreach ($allUserSkills as $userSkill) {
                if ($userSkill->reestr_id != $guid->getValue()) {
                    continue;
                }

                // Получаем improveLink для навыка согласно ID школы ($userSkill->user_group_id).
                $improveLink = $this->siteOptionRepository->findOneByName('attestationLink')->getValue();
                $macroWeight = 0;
                $weight = 0;
                $existingSkill = $this->skillRepository->findById($userSkill->id);
                if ($existingSkill) {
                    if (!$existingSkill->isActive()) {
                        continue;
                    }

                    $improveLinkEntity = $this->skillImproveLinkRepository->findBySkillIdAndSchoolId($userSkill->id, $userSkill->user_group_id);
                    // Если нет ссылки по школе пользователя - получить ссылку школы по умолчанию.
                    if (!$improveLinkEntity) {
                        $improveLinkEntity = $this->skillImproveLinkRepository->findBySkillIdAndSchoolId($userSkill->id, 0);
                    }
                    if ($improveLinkEntity) {
                        $improveLink = $improveLinkEntity->getLink();
                    }

                    $macroWeight = $existingSkill->getMacroWeight();
                    $weight = $existingSkill->getWeight();
                }

                $macroTypeId = $userSkill->macro_type_id;
                $macroId = $userSkill->macro_id;
                $skillId = $userSkill->id;

                $groupedByMacroTypeId[$macroTypeId]['id'] = $macroTypeId;
                $groupedByMacroTypeId[$macroTypeId]['name'] = $userSkill->macro_type_name;
                $groupedByMacroTypeId[$macroTypeId]['macros'][$macroId]['id'] = $macroId;
                $groupedByMacroTypeId[$macroTypeId]['macros'][$macroId]['name'] = $userSkill->macro_name;
                $groupedByMacroTypeId[$macroTypeId]['macros'][$macroId]['weight'] = $macroWeight;
                $groupedByMacroTypeId[$macroTypeId]['macros'][$macroId]['skills'][$skillId] = [
                    'percent' => $userSkill->percent,
                    'id' => $skillId,
                    'name' => $userSkill->name,
                    'degradation' => $userSkill->degradation,
                    'improveLink' => $improveLink,
                    'weight' => $weight,
                ];
            }
        }

        return $groupedByMacroTypeId;
    }

    /**
     * Сливает 2 массива навыков в один.
     *
     * Это нужно потому что из API не приходят навыки с percent = 0, поэтому со своей стороны мы добавляем их к ответу.
     *
     * @param array $availableSkills
     * @param array $formattedUserSkills
     *
     * @return array
     *
     * @psalm-suppress PossiblyNullArrayOffset
     */
    private function mergeSkills(array $availableSkills, array $formattedUserSkills): array
    {
        $result = $formattedUserSkills;

        /** @var Skill $skill */
        foreach ($availableSkills as $skill) {
            if (!$skill->isActive()) {
                continue;
            }

            $macroTypeId = $skill->getMacroTypeId();
            $macroSkillId = $skill->getMacroSkillId();
            $skillId = $skill->getId();

            // Если нет типа навыков - добавить.
            if (!isset($result[$macroTypeId])) {
                $result[$macroTypeId]['id'] = $macroTypeId;
                $result[$macroTypeId]['name'] = $skill->getMacroTypeName();
            }

            // Если нет группы навыков - добавить.
            if (!isset($result[$macroTypeId]['macros'][$macroSkillId])) {
                $result[$macroTypeId]['macros'][$macroSkillId]['id'] = $macroSkillId;
                $result[$macroTypeId]['macros'][$macroSkillId]['name'] = $skill->getMacroSkillName();
                $result[$macroTypeId]['macros'][$macroSkillId]['weight'] = $skill->getMacroWeight();
            }

            // Если нет навыка - добавить.
            if (!isset($result[$macroTypeId]['macros'][$macroSkillId]['skills'][$skillId])) {
                $improveLink = $this->siteOptionRepository->findOneByName('attestationLink')->getValue();

                // Если есть ссылка для школы "По умолчанию" - использовать ее.
                $improveLinkEntity = $this->skillImproveLinkRepository->findBySkillIdAndSchoolId($skillId, 0);
                if ($improveLinkEntity) {
                    $improveLink = $improveLinkEntity->getLink();
                }

                $result[$macroTypeId]['macros'][$macroSkillId]['skills'][$skillId] = [
                    'percent' => 0,
                    'id' => $skillId,
                    'name' => $skill->getName(),
                    'degradation' => 0,
                    'improveLink' => $improveLink,
                    'weight' => $skill->getWeight(),
                ];
            }
        }

        return $result;
    }

    /**
     * @param array $skills
     *
     * @return array
     */
    private function addDescriptionText(array $skills): array
    {
        if ($this->keySkillsId && $this->professionalGrowSkillsId) {
            $descriptionTexts = [
                $this->keySkillsId => $this->siteOptionRepository->findOneByName('keySkillsDescriptionText')->getValue(),
                $this->professionalGrowSkillsId => $this->siteOptionRepository->findOneByName('professionalGrowSkillsDescriptionText')->getValue(),
            ];

            foreach ($skills as $guid => &$skill) {
                $description = isset($descriptionTexts[$guid]) ? $descriptionTexts[$guid] : '';
                $skill['description'] = $description;
            }
        }

        return $skills;
    }

    /**
     * @param array $skills
     *
     * @return array
     */
    private function cleanUp(array $skills): array
    {
        // Вынести ключевые навыки вверх списка.
        $keySkillsId = $this->keySkillsId;
        if ($keySkillsId && isset($skills[$keySkillsId])) {
            $keySkills = $skills[$keySkillsId];
            unset($skills[$keySkillsId]);
            array_unshift($skills, $keySkills);
        }

        // Удаление ненужных ключей массивов.
        $skills = array_values($skills);
        foreach ($skills as &$macro) {
            $macro['macros'] = array_values($macro['macros']);
            foreach ($macro['macros'] as &$item) {
                $item['skills'] = array_values($item['skills']);

                unset($item['weight']);
                foreach ($item['skills'] as &$skill) {
                    unset($skill['weight']);
                }
            }
        }

        return $skills;
    }

    /**
     * @param array $skills
     * @return array
     */
    private function sortSkills(array $skills): array
    {
        foreach ($skills as &$macroType) {
            usort($macroType['macros'], [self::class, 'sortByWeight']);
            foreach ($macroType['macros'] as &$macroSkill) {
                usort($macroSkill['skills'], [self::class, 'sortByWeight']);
            }
        }

        return $skills;
    }

    /**
     * Callback для сортировки навыков по весу.
     *
     * @param $a
     * @param $b
     *
     * @return int
     */
    private function sortByWeight($a, $b): int
    {
        if ($a['weight'] == $b['weight']) {
            return 0;
        }

        return ($a['weight'] < $b['weight']) ? -1 : 1;
    }
}
