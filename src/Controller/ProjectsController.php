<?php

namespace App\Controller;

use App\Enum\ESkillType;
use App\Manager\CustomTranslationManager;
use App\Repository\ProjectRepository;
use App\Service\ProjectService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectsController extends AbstractController
{
    #[Route('/projects', name: 'portfolio_projects')]
    public function index(ProjectRepository $projectRepository, ProjectService $projectService): Response
    {
        $projects = $projectRepository->findAllWithSkills();
        $technicalFacetOptions = $projectService->getFacetOptionsWithType(ESkillType::TECH_SKILL);
        $softFacetOptions = $projectService->getFacetOptionsWithType(ESkillType::SOFT_SKILL);

        CustomTranslationManager::getInstance()->processTranslationRequests();

        return $this->render('pages/projects/projects.html.twig', [
            'projects' => $projects,
            'technicalFacetOptions' => $technicalFacetOptions,
            'softFacetOptions' => $softFacetOptions
        ]);
    }

    #[Route('/projects/{id}', name: 'project_show')]
    public function show(int $id, ProjectRepository $projectRepository): Response
    {
        $project = $projectRepository->findOneWithContentAndSkills($id);
        if (!$project) {
            return $this->redirectToRoute('portfolio_projects');
        }
        CustomTranslationManager::getInstance()->processTranslationRequests();
        return $this->render('pages/projects/project-view.html.twig', [
            'project' => $project
        ]);
    }
}
