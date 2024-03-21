<?php

namespace App\Controller;

use App\Repository\SkillGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AboutController extends AbstractController
{
    #[Route('/about', name: 'portfolio_about')]
    public function index(SkillGroupRepository $skillGroupRepository): Response
    {
        return $this->render('pages/about/about.html.twig', [
            'skillGroups' => $skillGroupRepository->findBy([], ['acquiredPercentage' => 'DESC']),
        ]);
    }
}
