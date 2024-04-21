<?php

namespace App\Controller\Admin;

use App\Entity\SkillGroup;
use App\Trait\CrudTranslatableTrait;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\RequestStack;

class SkillGroupCrudController extends AbstractCrudController
{
    use CrudTranslatableTrait;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public static function getEntityFqcn(): string
    {
        return SkillGroup::class;
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
            IdField::new('id'),
            TextField::new('customName'),
            NumberField::new('acquiredPercentage'),
            AssociationField::new('skills')
                ->formatValue(fn ($value) => $this->formatValue($value))
                ->autocomplete(),
        ];
    }
}
