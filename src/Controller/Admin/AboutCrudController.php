<?php

namespace App\Controller\Admin;

use App\Entity\About;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class AboutCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return About::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
                        ->setEntityLabelInPlural('A Propos')
                        ->setPaginatorPageSize(5)
                        ->setPageTitle(Crud::PAGE_DETAIL,fn (About $header) => sprintf(' <b>%s</b>', $header->getFullName()))             
                        ;
    }

    public function  configureActions(Actions $actions): Actions
    {
        return $actions 
        ->add(Crud::PAGE_INDEX, Action::DETAIL)

                ->update(Crud::PAGE_DETAIL, Action::EDIT, function(Action $action){
                    return $action->setIcon('fa fa-pencil')->setLabel(false);
                })
                ->update(Crud::PAGE_DETAIL, Action::DELETE, function(Action $action){
                    return $action->setLabel(false);
                })
                ->update(Crud::PAGE_DETAIL, Action::INDEX, function(Action $action){
                    return $action->setIcon('fa fa-right-from-bracket')->setLabel(false);
                })
                ->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action){
                    return $action->setIcon('fa fa-plus')->setLabel(false);
                })
                ->update(Crud::PAGE_INDEX, Action::EDIT, function(Action $action){
                    return $action->setLabel('Edit');
                })
                ->update(Crud::PAGE_INDEX, Action::DETAIL, function(Action $action){
                    return $action->setLabel('Voir');
                })
                ->update(Crud::PAGE_INDEX, Action::DELETE, function(Action $action){
                    return $action->setLabel('Supprimer');
                })

                ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function(Action $action){
                    return $action->setLabel('Sauver');
                })
                ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function(Action $action){
                    return $action->setLabel(false)->setIcon('fas fa-plus');
                })

                ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function(Action $action){
                    return $action->setLabel('Sauver');
                })
                ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function(Action $action){
                    return $action->setLabel('Sauver et Continuer');
                })
        ;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            TextField::new('fullName' , 'Nom complet'),
            TextField::new('title' , 'Competence')
            ->hideOnIndex(),
            DateField::new('birthday')
            ->hideOnIndex(),
            TextField::new('degree', 'Niveau d\' etudes'),
            IntegerField::new('experience', 'Annee d\'experience')
            ->hideOnIndex(),
            TelephoneField::new('phone', 'Numero telephone'),
            EmailField::new('email', 'Email'),
            BooleanField::new('freelance'),
            ImageField::new('imageName','Image')
            ->setBasePath('images/about/')
            ->setUploadDir('public/images/about/'),
            TextEditorField::new('address', 'Adresse du domicile')
            ->hideOnIndex(),
            TextEditorField::new('detail')
            ->hideOnIndex(),
            BooleanField::new('isPublic', 'Public')
          
        ];
    }
    
}
