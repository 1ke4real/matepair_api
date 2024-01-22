<?php

namespace App\Controller\Admin;

use App\Entity\WeekDay;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class WeekDayCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return WeekDay::class;
    }


    public function configureFields(string $pageName): iterable
    {
       yield IdField::new('id')->hideOnForm();
       yield TextField::new('name')->hideOnForm();
    }

}
