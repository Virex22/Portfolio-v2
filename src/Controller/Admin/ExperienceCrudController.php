<?php

namespace App\Controller\Admin;

use App\Entity\Experience;
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

class ExperienceCrudController extends AbstractCrudController
{
    use CrudTranslatableTrait;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public static function getEntityFqcn(): string
    {
        return Experience::class;
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
            TextField::new('compagnyName'),
            TextField::new('postName'),
            TextEditorField::new('description'),
            DateTimeField::new('startDate'),
            DateTimeField::new('EndDate'),
            ImageField::new('logo')
                ->setBasePath('/uploads/experiences/')
                ->onlyOnIndex(),
            TextField::new('logoFile')
                ->setFormType(VichImageType::class)
                ->onlyOnForms(),
            AssociationField::new('skills')
                ->formatValue(fn ($value) => $this->formatValue($value))
                ->setFormTypeOption('label', 'name')
                ->setFormTypeOption('by_reference', false)
                ->autocomplete(),
        ];
    }
}
