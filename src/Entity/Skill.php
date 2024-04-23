<?php

namespace App\Entity;

use App\Attributes\Translatable;
use App\Enum\ESkillType;
use App\Repository\SkillRepository;
use App\Trait\TranslatableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
#[Vich\Uploadable()]
class Skill
{
    use TranslatableTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Translatable(key: 'skill.name')]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $badgeUrl = null;

    #[Vich\UploadableField(mapping: 'app_skill', fileNameProperty: 'badgeUrl')]
    private ?File $badgeFile = null;

    #[ORM\Column(type: 'string', length: 50)]
    private string $type = ESkillType::TECH_SKILL;

    #[ORM\ManyToMany(targetEntity: Formation::class, inversedBy: 'skills')]
    private Collection $formations;

    #[ORM\ManyToMany(targetEntity: Experience::class, inversedBy: 'skills')]
    private Collection $experiences;

    #[ORM\ManyToMany(targetEntity: Project::class, inversedBy: 'skills')]
    private Collection $projects;

    #[ORM\ManyToOne(inversedBy: 'skills')]
    private ?SkillGroup $skillGroups = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private \DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->formations = new ArrayCollection();
        $this->experiences = new ArrayCollection();
        $this->projects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBadgeUrl(): ?string
    {
        return $this->badgeUrl;
    }

    public function setBadgeUrl(?string $badgeUrl): static
    {
        $this->badgeUrl = $badgeUrl;

        return $this;
    }
    public function setBadgeFile(?File $badgeFile = null): void
    {
        $this->badgeFile = $badgeFile;

        if (null !== $badgeFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getBadgeFile(): ?File
    {
        return $this->badgeFile;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        if (!in_array($type, ESkillType::toArray())) {
            throw new \InvalidArgumentException('Invalid type');
        }

        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(Formation $formation): static
    {
        if (!$this->formations->contains($formation)) {
            $this->formations->add($formation);
        }

        return $this;
    }

    public function removeFormation(Formation $formation): static
    {
        $this->formations->removeElement($formation);

        return $this;
    }

    /**
     * @return Collection<int, Experience>
     */
    public function getExperiences(): Collection
    {
        return $this->experiences;
    }

    public function addExperience(Experience $experience): static
    {
        if (!$this->experiences->contains($experience)) {
            $this->experiences->add($experience);
        }

        return $this;
    }

    public function removeExperience(Experience $experience): static
    {
        $this->experiences->removeElement($experience);

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        $this->projects->removeElement($project);

        return $this;
    }

    public function getSkillGroups(): ?SkillGroup
    {
        return $this->skillGroups;
    }

    public function setSkillGroups(?SkillGroup $skillGroups): static
    {
        $this->skillGroups = $skillGroups;

        return $this;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName() ?? '';
    }
}
