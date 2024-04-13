<?php

namespace App\Controller\Admin;

use App\Entity\ProjectContent;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProjectContentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProjectContent::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            NumberField::new('position'),
            TextField::new('view_type'),
            TextField::new('img_url'),
            TextEditorField::new('text_content'),
        ];
    }
}
