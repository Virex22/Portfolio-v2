<?php

namespace App\EventSubscriber;

use App\Attributes\Translatable;
use App\Entity\Translation;
use App\Helper\LocaleHelper;
use App\Manager\CustomTranslationManager;
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

    public static function getSubscribedEvents()
    {
        return [
            Events::postPersist => 'postPersist',
            Events::preUpdate => 'preUpdate',
            Events::postLoad => 'postLoad',
            Events::preRemove => 'preRemove',
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
        if (!Translatable::isTranslatableEntity($entity)) {
            return;
        }
        $locale = LocaleHelper::getLocales()[0];
        if ($this->requestStack->getCurrentRequest()) {
            $locale = $this->requestStack->getCurrentRequest()->getLocale();
        }
        $fields = Translatable::getTranslatableFields($entity);
        foreach ($fields as $field) {
            $key = Translatable::getTranslationKey($entity, $field);
            CustomTranslationManager::getInstance()->setEntityManager($this->entityManager)->requestTranslation($entity, $entity->getId(), $locale, $key, $field);
        }
    }

    #[PreRemove]
    public function preRemove($event): void
    {
        $entity = $event->getObject();
        if (!Translatable::isTranslatableEntity($entity)) {
            return;
        }
        $domains = Translatable::getTranslatableFields($entity);
        $translations = $this->translationRepository->findBy(['entity_id' => $entity->getId(), 'domain' => array_map(fn ($domain) => Translatable::getTranslationKey($entity, $domain), $domains)]);
        foreach ($translations as $translation) {
            $this->entityManager->remove($translation);
        }
        $this->entityManager->flush();
    }

    private function persistTranslatedFields(object $entity): void
    {
        if (!Translatable::isTranslatableEntity($entity)) {
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
}