<?php

namespace App\Helper;

use App\Entity\Configuration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class ConfigurationHelper
{
    private $configurationRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->configurationRepository = $entityManager->getRepository(Configuration::class);
    }

    /**
     * @param string $key
     * @param $defaultValue
     * @return string
     */
    public function getConfiguration(string $key, $defaultValue = null): string
    {
        $configuration = $this->configurationRepository->findOneBy(['name' => $key]);

        if ($configuration instanceof Configuration)
            return $configuration->getValue();

        if ($defaultValue !== null){
            $this->setConfiguration($key, $defaultValue);
            return $defaultValue;
        }

        throw new NotFoundResourceException("Configuration with key $key not found");
    }

    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public function setConfiguration(string $key, string $value): void
    {
        $configuration = $this->configurationRepository->findOneBy(['name' => $key]);

        if (!$configuration) {
            $configuration = (new Configuration())
                ->setName($key);
        }

        $configuration->setValue($value);

        $this->configurationRepository->add($configuration, true);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function existConfiguration(string $key): bool
    {
        return $this->configurationRepository->findOneBy(['name' => $key]) instanceof Configuration;
    }

    public function removeConfiguration(string $key): void
    {
        $configuration = $this->configurationRepository->findOneBy(['name' => $key]);

        if ($configuration instanceof Configuration)
            $this->configurationRepository->remove($configuration, true);
    }
}