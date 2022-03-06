<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; //creado
use Symfony\Component\Form\Extension\Core\Type\TextareaType;//creado
use Symfony\Component\Form\Extension\Core\Type\FileType;//para subir archivos

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo')
            ->add('foto', FileType::class,[ 'label' => 'Seleccione una imagen','mapped' => false,'required' => false,]) 
            ->add('contenido', TextareaType::class)
            ->add('guardad',SubmitType::class);
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
