<?php

namespace App\Controller\Admin;

use App\Entity\Skill;
use App\Trait\CrudTranslatableTrait;
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
        $this->requestStack = $requestStack;
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
            TextField::new('name'),
        ];
    }
}
