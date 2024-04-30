<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use App\Trait\CrudTranslatableTrait;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\RequestStack;

class ServiceCrudController extends AbstractCrudController
{
    use CrudTranslatableTrait;

    public function __construct(RequestStack $requestStack)
    {
        $this->translateInit($requestStack);
    }

    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name'),
            NumberField::new('priority'),
            TextEditorField::new('description'),
            TextField::new('subtitle'),
        ];
    }
}
