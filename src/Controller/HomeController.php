<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\LocaleSwitcher;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'portfolio_home')]
    public function index(ServiceRepository $serviceRepository, SkillRepository $skillRepository): Response
    {
        return $this->render('pages/home/home.html.twig', [
            'services' => $serviceRepository->findBy([], ['priority' => 'ASC']),
            'skills' => $skillRepository->findBy([], ['name' => 'ASC']),
        ]);
    }

    //change locale
    #[Route('/change-locale/{locale}', name: 'portfolio_locale')]
    public function changeLanguage(Request $request, string $locale, UrlGeneratorInterface $urlGenerator): RedirectResponse
    {
        // Stocke la locale choisie dans la session
        $request->getSession()->set('_locale', $locale);

        // Redirige vers la page précédente, ou une page par défaut si la précédente n'est pas disponible
        $referer = $request->headers->get('referer') ?? $urlGenerator->generate('portfolio_home');

        return new RedirectResponse($referer);
    }
}
