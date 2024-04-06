<?php

namespace App\Controller;

use App\Entity\Project;
use App\Enum\SkillType;
use App\Repository\ProjectRepository;
use App\Repository\SkillRepository;
use App\Service\ProjectService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectsController extends AbstractController
{
    #[Route('/projects', name: 'portfolio_projects')]
    public function index(ProjectRepository $projectRepository, ProjectService $projectService): Response
    {
        return $this->render('pages/projects/projects.html.twig', [
            'projects' => $projectRepository->findAll(),
            'technicalFacetOptions' => $projectService->getFacetOptionsWithType(SkillType::TECH_SKILL),
            'softFacetOptions' => $projectService->getFacetOptionsWithType(SkillType::SOFT_SKILL),
        ]);
    }

    #[Route('/projects/{id}', name: 'project_show')]
    public function show(int $id, ProjectRepository $projectRepository): Response
    {
        $project = $projectRepository->find($id);
        if (!$project) {
            return $this->redirectToRoute('portfolio_projects');
        }
        return $this->render('pages/projects/project-view.html.twig', [
            'project' => $project
        ]);
    }
}
