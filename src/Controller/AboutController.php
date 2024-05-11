<?php

namespace App\Controller;

use App\Helper\ConfigurationHelper;
use App\Manager\CustomTranslationManager;
use App\Repository\ExperienceRepository;
use App\Repository\FormationRepository;
use App\Repository\SkillGroupRepository;
use App\Service\AboutService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AboutController extends AbstractController
{
    #[Route('/about', name: 'portfolio_about')]
    public function index(
        SkillGroupRepository $skillGroupRepository,
        AboutService $aboutService,
        ConfigurationHelper $configurationHelper
    ): Response
    {
        $skillGroups = $skillGroupRepository->findAllWithSkills();
        $timeline = $aboutService->getTimeLineData();
        $cvLink = $configurationHelper->getConfiguration('CV_LINK', '#');

        return $this->render('pages/about/about.html.twig', [
            'skillGroups' => $skillGroups,
            'timeline' => $timeline,
            'cvLink' => $cvLink,
        ]);
    }
}
