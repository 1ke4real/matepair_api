<?php

namespace App\Controller\Admin;

use App\Entity\TimeDay;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TimeDayCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TimeDay::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('name')->hideOnForm();
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions->disable(Action::NEW);
        return parent::configureActions($actions);
    }
}
