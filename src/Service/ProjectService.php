<?php

namespace App\Service;

use App\Enum\ESkillType;
use App\Manager\CustomTranslationManager;
use App\Repository\SkillRepository;

class ProjectService
{
    private SkillRepository $skillRepository;

    public function __construct(SkillRepository $skillRepository)
    {
        $this->skillRepository = $skillRepository;
    }

    /**
     * Get technical facet options for projects.
     *
     * @param string $type ESkillType The skill type in ESkillType enum.
     * @return array
     */
    public function getFacetOptionsWithTypeAndSkill(string $type): array
    {
        $skills = $this->skillRepository->findAllByTypeAndSkill($type);
        $skillsOptions = [
            [
                'value' => 'all',
                'label' => 'Tous'
            ]
        ];

        CustomTranslationManager::getInstance()->processTranslationRequests();

        foreach ($skills as $skill) {
            $skillsOptions[] = [
                'value' => $skill->getId(),
                'label' => $skill->getName()
            ];
        }
        return $skillsOptions;
    }
}