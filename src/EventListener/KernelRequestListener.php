<?php

namespace App\EventListener;

use App\Helper\ConfigurationHelper;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Twig\Environment;

class KernelRequestListener
{
    public static $maintenanceConfigKey = 'APP_MAINTENANCE';
    private Environment $twig;
    private ConfigurationHelper $configurationHelper;

    public function __construct(Environment $twig, ConfigurationHelper $configurationHelper)
    {
        $this->twig = $twig;
        $this->configurationHelper = $configurationHelper;
    }

    #[AsEventListener(event: RequestEvent::class, priority: 5000)]
    public function onKernelRequest(RequestEvent $event): void
    {
        foreach ($this->getExcludeRoutes() as $route) {
            if (str_starts_with($event->getRequest()->getPathInfo(), "/" . $route)) {
                return;
            }
        }

        if (!$this->configurationHelper->existConfiguration(self::$maintenanceConfigKey)) {
            $this->configurationHelper->setConfiguration(self::$maintenanceConfigKey, 'false');
            return;
        }

        if ($this->configurationHelper->getConfiguration(self::$maintenanceConfigKey) !== 'true') {
            return;
        }

        $response = new Response($this->twig->render('pages/maintenance/maintenance.html.twig'), Response::HTTP_SERVICE_UNAVAILABLE);

        $event->setResponse($response);
        $event->stopPropagation();
    }

    private function getExcludeRoutes(): array
    {
        return [
            $_ENV['ADMIN_PATH'],
            "_profiler",
            "_fragment",
        ];
    }
}