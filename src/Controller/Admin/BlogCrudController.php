<?php

namespace App\Controller\Admin;

use App\Entity\Blog;
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
class BlogCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Blog::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
                        ->setEntityLabelInPlural('Realisation')
                        ->setPaginatorPageSize(5)
                        ->setPageTitle(Crud::PAGE_DETAIL,fn (Blog $header) => sprintf(' <b>%s</b>', $header->getName()))   
                        ->setPageTitle(Crud::PAGE_EDIT,fn (Blog $header) => sprintf(' Edit <b>%s</b>', $header->getName()))                        
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
            TextField::new('name'),
            ImageField::new('imageName','Image')
            ->setBasePath('images/blog/')
            ->setUploadDir('public/images/blog/'),
            TextEditorField::new('detail'),
            DateTimeField::new('updatedAt', 'Mis a jour')
            ->hideOnForm(),
        ];
    }
    
}