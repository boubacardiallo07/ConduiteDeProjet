<?php

namespace App\Form;

use App\Entity\Sprint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SprintCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('CreationDate')
            ->add('endingDate')
            ->add('dailyAndRestrospectivePlanning')
            ->add('project')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sprint::class,
        ]);
    }
}
