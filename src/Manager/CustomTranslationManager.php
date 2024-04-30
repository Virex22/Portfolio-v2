<?php

namespace App\Manager;

use App\Attributes\Translatable;
use App\Entity\Translation;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CustomTranslationManager
 *
 * Used to manage custom translations and gain performance by reducing the number of queries
 * @package App\Manager
 */
class CustomTranslationManager
{
    private bool $active = true;
    private static CustomTranslationManager $instance;
    private array $translationRequests = [];
    private EntityManagerInterface $entityManager;

    private function __construct()
    {
    }

    public static function getInstance(): CustomTranslationManager
    {
        if (!isset(self::$instance)) {
            self::$instance = new CustomTranslationManager();
        }

        return self::$instance;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): CustomTranslationManager
    {
        $this->active = $active;

        return $this;
    }

    public function setEntityManager(EntityManagerInterface $entityManager) : CustomTranslationManager
    {
        $this->entityManager = $entityManager;

        return $this;
    }

    public function requestTranslation(object $entity, int $entityId, string $locale, string $key, string $field): void
    {
        $this->translationRequests[] = ['entity' => $entity, 'entityId' => $entityId, 'locale' => $locale, 'key' => $key, 'field' => $field];
        if (!$this->active) {
            $this->processTranslationRequests();
        }
    }

    public function processTranslationRequests(): void
    {

        if (empty($this->translationRequests)) {
            return;
        }

        if (empty($this->entityManager)) {
            throw new \Exception('Entity manager is not set');
        }

        $entityIds = array_column($this->translationRequests, 'entityId');
        $locales = array_column($this->translationRequests, 'locale');
        $keys = array_column($this->translationRequests, 'key');

        $translations = $this->entityManager->getRepository(Translation::class)->findBy([
            'entity_id' => $entityIds,
            'locale' => $locales,
            'domain' => $keys,
        ]);

        foreach ($this->translationRequests as $request) {
            $translation = $this->findTranslation($translations, $request['entityId'], $request['locale'], $request['key']);
            if ($translation) {
                $camelizedAttributeName = ucfirst(str_replace('_', '', lcfirst($request['field'])));
                $setter = 'set' . $camelizedAttributeName;
                if (method_exists($request['entity'], $setter)) {
                    $request['entity']->$setter($translation->getValue());
                }
            }
        }

        $this->translationRequests = [];
    }

    private function findTranslation(array $translations, int $entityId, string $locale, string $key): ?Translation
    {
        foreach ($translations as $translation) {
            if ($translation->getEntityId() === $entityId && $translation->getLocale() === $locale && $translation->getDomain() === $key) {
                return $translation;
            }
        }

        return null;
    }
}