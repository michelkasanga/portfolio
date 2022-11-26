<?php

namespace App\Form;

use App\Entity\Quality;
use App\Entity\QualityContent;
use App\Repository\QualityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QualityContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('post')
            ->add('company')
            ->add('startedAt')
            ->add('endedAt')
            ->add('content')
            ->add('quality', EntityType::class,   [
                'class'=> Quality::class,
                'query_builder'=> function (QualityRepository $r){
                    return $r->createQueryBuilder('i')
                        ->orderBy('i.name', 'ASC');
                        
                },
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'name'
            ]

           ) 

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QualityContent::class,
        ]);
    }
}
