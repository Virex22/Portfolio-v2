<?php

namespace App\Service;

use App\Manager\CustomTranslationManager;
use App\Repository\ExperienceRepository;
use App\Repository\FormationRepository;

class AboutService
{
    private FormationRepository $formationRepository;
    private ExperienceRepository $experienceRepository;

    public function __construct(FormationRepository $formationRepository, ExperienceRepository $experienceRepository)
    {
        $this->formationRepository = $formationRepository;
        $this->experienceRepository = $experienceRepository;
    }


    /**
     * Get formation and professional experience data and merge in one tab
     * order it by date (most recent first)
     * @return array [
     *     1 => [
     *        'type' => 'formation',
     *       'startDate' => 2021-01-01,
     *      'endDate' => 2021-01-01,
     *      'name' => 'formation name',
     *    'skills' => ['skill1', 'skill2'],
     *     'subtitle' => 'school name',
     *    'location' => 'location',
     *      'logoUrl' => 'logo image',
     *     'description' => 'description',
     *    ],
     *      2 => [
     *      'type' => 'experience',
     *     'startDate' => 2020-01-01,
     *     'endDate' => 2021-01-01,
     *      'name' => 'experience name',
     *    'skills' => ['skill1', 'skill2'],
     *     'subtitle' => 'post name',
     *    'location' => 'location',
     *     'logoUrl' => 'logo image',
     *    'description' => 'description',
     *      ]
     */
    public function getTimeLineData(): array
    {
        $formations = $this->formationRepository->findAllWithSkills();
        $experiences = $this->experienceRepository->findAllWithSkills();
        CustomTranslationManager::getInstance()->processTranslationRequests();
        $timelineData = [];

        foreach ($formations as $formation) {
            $timelineData[] = [
                'type' => 'formation',
                'startDate' => $formation->getStartDate(),
                'endDate' => $formation->getEndDate(),
                'name' => $formation->getName(),
                'skills' => $formation->getSkills(),
                'subtitle' => $formation->getSchoolName(),
                'location' => $formation->getLocation(),
                'logoUrl' => '/uploads/formations/' . $formation->getLogo(),
                'description' => $formation->getDescription(),
            ];
        }

        foreach ($experiences as $experience) {
            $timelineData[] = [
                'type' => 'experience',
                'startDate' => $experience->getStartDate(),
                'endDate' => $experience->getEndDate(),
                'name' => $experience->getCompanyName(),
                'skills' => $experience->getSkills(),
                'subtitle' => $experience->getPostName(),
                'location' => $experience->getLocation(),
                'logoUrl' => '/uploads/experiences/' . $experience->getLogo(),
                'description' => $experience->getDescription(),
            ];
        }

        usort($timelineData, function ($a, $b) {
            return $b['startDate'] <=> $a['startDate'];
        });

        return $timelineData;
    }
}