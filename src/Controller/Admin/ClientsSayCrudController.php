<?php

namespace App\Controller\Admin;

use App\Entity\ClientsSay;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class ClientsSayCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ClientsSay::class;
    }

   
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
                        ->setEntityLabelInPlural('Propos de client')
                        ->setPaginatorPageSize(5)
                        ->setPageTitle(Crud::PAGE_DETAIL,fn (ClientsSay $header) => sprintf(' <b>%s</b>', $header->getFullName()))  
                        ->setPageTitle(Crud::PAGE_EDIT,fn (ClientsSay $header) => sprintf(' Editer les message de  <b>%s</b>', $header->getFullName()))                         
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
            TextField::new('fullName', 'Nom complet'),
            TextField::new('profession'),
            ImageField::new('imageName','Image')
            ->setBasePath('images/clientsSay/')
            ->setUploadDir('public/images/clientsSay/'),
            TextEditorField::new('message'),
            DateTimeField::new('updatedAt', 'Mis a jour')
            ->hideOnForm(),
        ];
    }
    
}
