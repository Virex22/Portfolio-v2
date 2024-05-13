<?php

namespace App\Controller\Admin;

use App\Entity\Formation;
use App\Trait\CrudTranslatableTrait;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\RequestStack;
use Vich\UploaderBundle\Form\Type\VichImageType;

class FormationCrudController extends AbstractCrudController
{
    use CrudTranslatableTrait;

    public function __construct(RequestStack $requestStack)
    {
        $this->translateInit($requestStack);
    }

    public static function getEntityFqcn(): string
    {
        return Formation::class;
    }

    private function formatValue($value)
    {
        $skills = [];
        foreach ($value as $skill) {
            $skills[] = $skill->getName();
        }
        return implode(', ', $skills);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextEditorField::new('description'),
            DateTimeField::new('startDate')->onlyOnForms(),
            DateTimeField::new('endDate')->onlyOnForms(),
            TextField::new('location'),
            ImageField::new('logo')
                ->setBasePath('/uploads/formations/')
                ->onlyOnIndex(),
            TextField::new('logoFile')
                ->setFormType(VichImageType::class)
                ->onlyOnForms(),
            AssociationField::new('skills')
                ->formatValue(fn ($value) => $this->formatValue($value))
                ->setFormTypeOption('label', 'Skills')
                ->setFormTypeOption('by_reference', false)
                ->autocomplete(),

        ];
    }
}
