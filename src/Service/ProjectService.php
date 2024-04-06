<?php

namespace App\Service;

use App\Enum\SkillType;
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
     * @param string $type SkillType The skill type in SkillType enum.
     * @return array
     */
    public function getFacetOptionsWithType(string $type): array
    {
        $skills = $this->skillRepository->findAllByType($type);
        $skillsOptions = [];

        foreach ($skills as $skill) {
            $skillsOptions[] = [
                'value' => $skill->getId(),
                'label' => $skill->getName()
            ];
        }
        return $skillsOptions;
    }
}