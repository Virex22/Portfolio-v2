<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectsController extends AbstractController
{
    #[Route('/projects', name: 'portfolio_projects')]
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('pages/projects/projects.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }
}
