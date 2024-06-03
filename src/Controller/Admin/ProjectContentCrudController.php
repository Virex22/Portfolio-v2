<?php

namespace App\Controller\Admin;

use App\Entity\ProjectContent;
use App\Enum\EProjectViewType;
use App\Trait\CrudTranslatableTrait;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\RequestStack;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProjectContentCrudController extends AbstractCrudController
{
    use CrudTranslatableTrait;

    public function __construct(RequestStack $requestStack)
    {
        $this->translateInit($requestStack);
    }

    public static function getEntityFqcn(): string
    {
        return ProjectContent::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('project')
                ->formatValue(fn($value) => $value->getId())
                ->autocomplete(),
            NumberField::new('position'),
            TextField::new('view_type')
                ->setHelp($this->getViewType()),
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('image')->setBasePath('/uploads/projects-content')->onlyOnIndex(),
            TextEditorField::new('text_content')
                // set text center aligned to twix editor
                ->setTrixEditorConfig([
                    'toolbar' => [
                        'text-align-center',
                    ]
                ]),
        ];

    }

    private function getViewType()
    {
        $types = EProjectViewType::toArray();
        return implode(', ', $types);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['project' => 'DESC', 'position' => 'DESC']);
    }
}
