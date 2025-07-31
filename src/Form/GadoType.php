<?php

namespace App\Form;

use App\Entity\Fazenda;
use App\Entity\Gado;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GadoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codigo')
            ->add('peso')
            ->add('racao')
            ->add('leite')
            ->add('nascimento')
            ->add('abate')
            ->add('fazenda', EntityType::class, [
                'class' => Fazenda::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Gado::class,
        ]);
    }
}
