<?php

namespace App\Service;

use App\Repository\ExperienceRepository;
use App\Repository\FormationRepository;

class AboutService
{
    private FormationRepository $skillGroupRepository;
    private ExperienceRepository $experienceRepository;

    public function __construct(FormationRepository $skillGroupRepository, ExperienceRepository $experienceRepository)
    {
        $this->skillGroupRepository = $skillGroupRepository;
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
     *  'name' => 'formation name',
     *    ],
     *      2 => [
     *      'type' => 'experience',
     *     'startDate' => 2020-01-01,
     *     'endDate' => 2021-01-01,
     *      'name' => 'experience name',
     *      'logo' => 'company logo url',
     *      ]
     */
    public function getTimeLineData(): array
    {
        $formations = $this->skillGroupRepository->findBy([], ['startDate' => 'DESC']);
        $experiences = $this->experienceRepository->findBy([], ['startDate' => 'DESC']);

        $timelineData = [];

        foreach ($formations as $formation) {
            $timelineData[] = [
                'type' => 'formation',
                'startDate' => $formation->getStartDate(),
                'endDate' => $formation->getEndDate(),
                'name' => $formation->getName(),
            ];
        }

        foreach ($experiences as $experience) {
            $timelineData[] = [
                'type' => 'experience',
                'startDate' => $experience->getStartDate(),
                'endDate' => $experience->getEndDate(),
                'name' => $experience->getCompagnyName(),
                'logo' => $experience->getCompangyLogoUrl(),
            ];
        }

        usort($timelineData, function ($a, $b) {
            return $b['startDate'] <=> $a['startDate'];
        });

        return $timelineData;
    }
}