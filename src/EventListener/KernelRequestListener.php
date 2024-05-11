<?php

namespace App\EventListener;

use App\Helper\ConfigurationHelper;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Translation\LocaleSwitcher;
use Twig\Environment;

class KernelRequestListener
{
    public static $maintenanceConfigKey = 'APP_MAINTENANCE';
    private Environment $twig;
    private ConfigurationHelper $configurationHelper;
    private LocaleSwitcher $localeSwitcher;

    public function __construct(Environment $twig, ConfigurationHelper $configurationHelper, LocaleSwitcher $localeSwitcher)
    {
        $this->twig = $twig;
        $this->configurationHelper = $configurationHelper;
        $this->localeSwitcher = $localeSwitcher;
    }

    #[AsEventListener(event: RequestEvent::class, priority: 5000)]
    public function onKernelRequest(RequestEvent $event): void
    {
        foreach ($this->getExcludeRoutes() as $route) {
            if (str_starts_with($event->getRequest()->getPathInfo(), "/" . $route)) {
                return;
            }
        }


        $maintenanceConfig = $this->configurationHelper->getConfiguration(self::$maintenanceConfigKey, 'false');

        if ($maintenanceConfig !== 'true') {
            return;
        }

        $response = new Response($this->twig->render('pages/maintenance/maintenance.html.twig'), Response::HTTP_SERVICE_UNAVAILABLE);

        $event->setResponse($response);
        $event->stopPropagation();
    }

    #[AsEventListener(event: RequestEvent::class, priority: 1000)]
    public function onKernelRequestLocale(RequestEvent $event): void
    {
        $request = $event->getRequest();
        if (!isset($_SESSION)) {
            session_start();
        }
        $locale = $_SESSION['_sf2_attributes']['_locale'] ?? null;
        session_write_close();

        if (!$locale) {
            $availableLocales = json_decode($this->configurationHelper->getConfiguration('APP_SUPPORTED_LOCALES', '["en","fr"]'));

            if (!in_array($locale, $availableLocales)) {
                return;
            }
        }

        $this->localeSwitcher->setLocale($locale);

        if ($locale) {
            $request->setLocale($locale);
        }
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