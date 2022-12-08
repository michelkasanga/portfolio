<?php

namespace App\Controller\Admin;

use App\Entity\Quality;
use App\Entity\QualityContent;
use App\Controller\Admin\QualityCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class QualityContentCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return QualityContent::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
                        ->setEntityLabelInPlural('Etudes et  Experiences')
                        ->setEntityLabelInSingular('Etude et  Experience')
                        ->setPaginatorPageSize(5)
                        ->setPageTitle(Crud::PAGE_DETAIL,fn (QualityContent $header) => sprintf(' <b>%s</b>', $header->getPost()))     
                        ->setPageTitle(Crud::PAGE_EDIT,fn (QualityContent $header) => sprintf(' Edit <b>%s</b>', $header->getPost()))            
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
            IdField::new ('id')
                ->hideOnForm(),
            TextField::new ('post'),
            TextField::new('company', 'Companie '),
            AssociationField::new ('quality')
                ->setCrudController(QualityCrudController::class)
                // ->autocomplete()
                // ->renderAsNativeWidget()
                ,
                IntegerField::new('startedAt', 'Debut'),
                TextField::new('endedAt', 'Fin'),
                TextEditorField::new('content', 'Detail')

        ];
    }

}
