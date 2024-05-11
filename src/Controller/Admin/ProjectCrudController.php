<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Manager\CustomTranslationManager;
use App\Trait\CrudTranslatableTrait;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProjectCrudController extends AbstractCrudController
{
    use CrudTranslatableTrait;

    public function __construct(RequestStack $requestStack)
    {
        $this->translateInit($requestStack);
    }

    public static function getEntityFqcn(): string
    {
        return Project::class;
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
            TextField::new('name'),
            TextField::new('description'),
            AssociationField::new('skills')
                ->formatValue(fn ($value) => $this->formatValue($value))
                ->setFormTypeOption('label', 'name')
                ->setFormTypeOption('by_reference', false)
                ->autocomplete(),
            TextField::new('coverImageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('coverImage')->setBasePath('/uploads/projects')->onlyOnIndex(),
        ];
    }
}
