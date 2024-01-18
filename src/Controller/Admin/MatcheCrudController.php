<?php

namespace App\Controller\Admin;

use App\Entity\Matche;
use App\Enum\MatchStatus;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class MatcheCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Matche::class;
    }


    public function configureFields(string $pageName): iterable
    {
       yield IdField::new('id')->hideOnForm();
       yield ChoiceField::new('status')
             ->setFormType(EnumType::class)
             ->setFormTypeOption('class', MatchStatus::class);
       yield AssociationField::new('user_first');
       yield AssociationField::new('user_second');
    }

}
