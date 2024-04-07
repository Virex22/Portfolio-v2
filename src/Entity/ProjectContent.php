<?php

namespace App\Entity;

use App\Enum\EProjectViewType;
use App\Repository\ProjectContentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectContentRepository::class)]
class ProjectContent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\Column(length: 50)]
    private ?string $view_type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img_url = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text_content = null;

    #[ORM\ManyToOne(inversedBy: 'projectContents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Project $project = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getViewType(): ?string
    {
        return $this->view_type;
    }

    public function setViewType(string $view_type): static
    {
        if (!in_array($view_type, EProjectViewType::toArray())) {
            throw new \InvalidArgumentException('Invalid view type');
        }

        $this->view_type = $view_type;

        return $this;
    }

    public function getImgUrl(): ?string
    {
        return $this->img_url;
    }

    public function setImgUrl(?string $img_url): static
    {
        $this->img_url = $img_url;

        return $this;
    }

    public function getTextContent(): ?string
    {
        return $this->text_content;
    }

    public function setTextContent(?string $text_content): static
    {
        $this->text_content = $text_content;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }
}
