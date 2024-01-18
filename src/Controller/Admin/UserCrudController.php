<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;


class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }




    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('username');
        yield EmailField::new('email');
        yield TextField::new('password')->hideOnIndex()->hideOnForm()->hideOnDetail();
        yield ArrayField::new('roles')->hideOnForm()->hideOnDetail()->hideOnIndex();
        yield TextEditorField::new('details');
        yield CodeEditorField::new('favorite_games')->setLanguage('js')->hideOnForm()->hideOnIndex()->hideOnDetail();// Utilisez le même template que pour le formulaire
        yield TextField::new('play_schedule')->hideOnForm()->hideOnIndex()->hideOnDetail();
    }

}
