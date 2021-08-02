<?php

namespace App\Infrastructure\HttpClients\Skills;

use App\Infrastructure\HttpClients\Skills\Assembler\SkillsResponseAssemblerInterface;

/**
 * Class SkillsService.
 *
 * @package App\Infrastructure\HttpClients\Skills
 */
class SkillsService
{
    /**
     * @var SkillsClientInterface
     */
    private SkillsClientInterface $skillsClient;

    /**
     * @var SkillsResponseAssemblerInterface
     */
    private SkillsResponseAssemblerInterface $skillsResponseAssembler;

    public function __construct(
        SkillsClientInterface $skillsClient,
        SkillsResponseAssemblerInterface $skillsResponseAssembler
    ) {
        $this->skillsClient = $skillsClient;
        $this->skillsResponseAssembler = $skillsResponseAssembler;
    }

    /**
     * @param string $guid
     *
     * @return array
     */
    public function getByRegistryId(string $guid)
    {
        $skills = [];
        $response = $this->skillsClient->getByRegistryId($guid);

        foreach ($response as $item) {
            $skills[] = $this->skillsResponseAssembler->assemble($item);
        }

        return $skills;
    }
}
