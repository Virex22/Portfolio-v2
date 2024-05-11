<?php

namespace App\Controller\Admin;

use App\Entity\Configuration;
use App\Entity\ContactMessage;
use App\Entity\Experience;
use App\Entity\Formation;
use App\Entity\Project;
use App\Entity\ProjectContent;
use App\Entity\Service;
use App\Entity\Skill;
use App\Entity\SkillGroup;
use App\Helper\LocaleHelper;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use phpDocumentor\Reflection\Types\Parent_;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    #[Route('/', name: 'admin')]
    public function index(): Response {
        $url = $this->adminUrlGenerator->setController(ConfigurationCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Portfolio2');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Entities');
        yield MenuItem::linkToCrud('Configuration', 'fas fa-cogs', Configuration::class);
        yield MenuItem::linkToCrud('ContactMessages', 'fas fa-envelope', ContactMessage::class);
        yield MenuItem::linkToCrud('Experience', 'fas fa-briefcase', Experience::class);
        yield MenuItem::linkToCrud('Formation', 'fas fa-graduation-cap', Formation::class);
        yield MenuItem::linkToCrud('ProjectContent', 'fas fa-file', ProjectContent::class);
        yield MenuItem::linkToCrud('Project', 'fas fa-project-diagram', Project::class);
        yield MenuItem::linkToCrud('Service', 'fas fa-handshake', Service::class);
        yield MenuItem::linkToCrud('Skill', 'fas fa-cogs', Skill::class);
        yield MenuItem::linkToCrud('SkillGroup', 'fas fa-cogs', SkillGroup::class);
        yield MenuItem::section('Translation');
        foreach (LocaleHelper::getLocales() as $locale) {
            yield MenuItem::linkToRoute($locale, 'fas fa-language', 'portfolio_locale', ['locale' => $locale]);
        }
    }
}
