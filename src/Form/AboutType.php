<?php

namespace App\Form;

use App\Entity\About;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AboutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('fullName', TextType::class)
            ->add('imageFile', VichImageType::class)
            ->add('birthday', DateType::class)
            ->add('experience', IntegerType::class)
            ->add('phone', TelType::class)
            ->add('email', EmailType::class)
            ->add('address',TextType::class)
            ->add('freelance', CheckboxType::class)
            ->add('detail', TextareaType::class)
            ->add('submit', SubmitType::class)
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => About::class,
        ]);
    }
}
