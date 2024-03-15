<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'portfolio_home')]
    public function index(ServiceRepository $serviceRepository, SkillRepository $skillRepository): Response
    {
        return $this->render('pages/home/home.html.twig', [
            'services' => $serviceRepository->findBy([], ['priority' => 'ASC'],1),
            'skills' => $skillRepository->findBy([], ['name' => 'ASC'],1),
        ]);
    }
}
