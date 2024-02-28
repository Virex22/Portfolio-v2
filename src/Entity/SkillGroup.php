<?php

namespace App\Entity;

use App\Repository\SkillGroupRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SkillGroupRepository::class)]
class SkillGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $customName = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $acquiredPercentage = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $priority = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomName(): ?string
    {
        return $this->customName;
    }

    public function setCustomName(?string $customName): static
    {
        $this->customName = $customName;

        return $this;
    }

    public function getAcquiredPercentage(): ?int
    {
        return $this->acquiredPercentage;
    }

    public function setAcquiredPercentage(int $acquiredPercentage): static
    {
        $this->acquiredPercentage = $acquiredPercentage;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): static
    {
        $this->priority = $priority;

        return $this;
    }
}
