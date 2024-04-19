<?php

namespace App\Entity;

use App\Attributes\Translatable;
use App\Enum\EProjectViewType;
use App\Interface\ITranslatable;
use App\Repository\ProjectContentRepository;
use App\Trait\TranslatableTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: ProjectContentRepository::class)]
#[Vich\Uploadable]
class ProjectContent implements ITranslatable
{
    use TranslatableTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\Column(length: 50)]
    private ?string $view_type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'project_content_images', fileNameProperty: 'image')]
    private ?File $imageFile = null;

    #[Translatable(key: 'project_content.text_content')]
    private ?string $text_content = null;

    #[ORM\ManyToOne(inversedBy: 'projectContents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Project $project = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

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
