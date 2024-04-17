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

    #[AsEventListener(event: RequestEvent::class, priority: 1000)]
    public function onKernelRequestLocale(RequestEvent $event): void
    {
        $request = $event->getRequest();
        // handle session manually because priority is too high for session listener
        session_start();
        $locale = $_SESSION['_sf2_attributes']['_locale'] ?? null;

        if (!$locale) {
            try {
                $availableLocales = json_decode($this->configurationHelper->getConfiguration('APP_SUPPORTED_LOCALES'));
                if (!is_array($availableLocales)) {
                    $this->configurationHelper->setConfiguration('APP_SUPPORTED_LOCALES', "['en','fr']");
                    return;
                }
                if (!in_array($locale, $availableLocales)) {
                    return;
                }
            } catch (\Exception $e) {
                $this->configurationHelper->setConfiguration('APP_SUPPORTED_LOCALES', "['en','fr']");
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