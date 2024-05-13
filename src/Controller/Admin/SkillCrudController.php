<?php

namespace App\Controller\Admin;

use App\Entity\Skill;
use App\Enum\ESkillType;
use App\Trait\CrudTranslatableTrait;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\HttpFoundation\RequestStack;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SkillCrudController extends AbstractCrudController
{
   use CrudTranslatableTrait;

    public function __construct(RequestStack $requestStack)
    {
        $this->translateInit($requestStack);
    }

    public static function getEntityFqcn(): string
    {
        return Skill::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('badgeFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('badgeUrl')->setBasePath('/uploads/skills')->onlyOnIndex(),
            TextField::new('type')->setHelp($this->getSkillType()),
            TextField::new('name'),
        ];
    }

    private function getSkillType()
    {
        $types = ESkillType::toArray();
        return implode(', ', $types);
    }
}
