<?php

namespace App\EventSubscriber;

use App\Attributes\Translatable;
use App\Entity\Project;
use App\Entity\Translation;
use App\Helper\LocaleHelper;
use App\Interface\ITranslatable;
use App\Repository\TranslationRepository;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\PostLoad;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\PreRemove;
use Doctrine\ORM\Mapping\PreUpdate;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsDoctrineListener(event: Events::postPersist)]
#[AsDoctrineListener(event: Events::preUpdate)]
#[AsDoctrineListener(event: Events::postLoad)]
#[AsDoctrineListener(event: Events::preRemove)]
class TranslatableSubscriber implements EventSubscriberInterface
{
    private TranslationRepository $translationRepository;
    private EntityManagerInterface $entityManager;
    private RequestStack $requestStack;

    public function __construct(TranslationRepository $translationRepository, EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->translationRepository = $translationRepository;
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::preUpdate,
            Events::postLoad,
            Events::preRemove,
        ];
    }

    #[PrePersist]
    public function postPersist(PostPersistEventArgs $event): void
    {
        $this->persistTranslatedFields($event->getObject());
    }

    #[PreUpdate]
    public function preUpdate(PreUpdateEventArgs $event): void
    {
        $this->persistTranslatedFields($event->getObject());
    }

    #[PostLoad]
    public function postLoad($event): void
    {
        $entity = $event->getObject();
        if (!($entity instanceof ITranslatable)) {
            return;
        }
        $locale = LocaleHelper::getLocales()[0];
        if ($locale = $this->requestStack->getCurrentRequest()) {
            $locale = $this->requestStack->getCurrentRequest()->getLocale();
        }
        $translations = $this->translationRepository->findBy(['entity_id' => $entity->getId(), 'locale' => $locale]);
        $this->setTranslatedField($entity, $translations);
    }

    #[PreRemove]
    public function preRemove($event): void
    {
        $entity = $event->getObject();
        if (!($entity instanceof ITranslatable)) {
            return;
        }
        $translations = $this->translationRepository->findBy(['entity_id' => $entity->getId()]);
        foreach ($translations as $translation) {
            $this->entityManager->remove($translation);
        }
        $this->entityManager->flush();
    }

    private function persistTranslatedFields(object $entity): void
    {
        if (!($entity instanceof ITranslatable)) {
            return;
        }
        $translatableFields = Translatable::getTranslatableFields($entity);
        //get all value of translatable fields
        foreach ($translatableFields as $translatableField) {
            $values = $entity->getAllTranslatedFields($translatableField);
            if ($values) {
                foreach ($values as $locale => $value) {
                    $key = Translatable::getTranslationKey($entity, $translatableField);
                    $this->persistOrUpdateTranslation($entity, $key, $value, $locale);
                }
            }
        }
    }

    private function persistOrUpdateTranslation(object $entity, string $domain, string $value, string $locale): void
    {
        $translation = $this->translationRepository->findOneBy([
            'entity_id' => $entity->getId(),
            'locale' => $locale,
            'domain' => $domain,
        ]);
        if (!$translation) {
            $translation = new Translation();
            $translation->setEntityId($entity->getId())
                ->setLocale($locale)
                ->setDomain($domain);
        }
        $translation->setValue($value);
        $this->entityManager->persist($translation);
        $this->entityManager->flush();
    }

    private function setTranslatedField(object $entity, array $translations): void
    {
        $fields = Translatable::getTranslatableFields($entity);
        foreach ($fields as $field) {
            $key = Translatable::getTranslationKey($entity, $field);
            foreach ($translations as $translation) {
                if ($translation->getDomain() === $key) {
                    $camelizedAttributeName = ucfirst(str_replace('_', '', lcfirst($field)));
                    $setter = 'set' . $camelizedAttributeName;
                    if (method_exists($entity, $setter)) {
                        $entity->$setter($translation->getValue());
                    }
                }
            }
        }
    }

}