<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\User;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType as TypeEntityType;
use Symfony\Component\Console\Color;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\DataTransformer\ChoicesToValuesTransformer;
use Symfony\Component\Form\Extension\Core\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\NotBlank;

class TaskCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'color',
                ChoiceType::class,
                [
                    'choices'  => [

                        'Red' => "priorité très forte",
                        'Orange' => "priorité forte",
                        'Blue' => "priorité moyenne",
                        'Green' => "priorité faible",
                    ],
                    'constraints' => [new NotBlank()]
                ]
            )

            ->add('title', TextType::class, [

                'constraints' => [new NotBlank()]
            ])
            ->add('description', TextType::class, [
                'constraints' => [new NotBlank()]
            ])
            ->add(
                'estimation',
                IntegerType::class,
                [
                    'constraints' => [new NotBlank()]
                ]
            )
            //Pas besoin
            ->add('creationDate', DateType::class, [
                'constraints' => [new NotBlank()],
                'data' => new DateTime()
            ])
            //Pas besoin
            ->add('columnUpdate')
            ->add('assignation', TypeEntityType::class, [
                // looks for choices from this entity
                'class' => User::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'username',
                'label' => 'Assignation',
                'placeholder' => 'Username',

                // used to render a select box, check boxes or radios
                'multiple' => true,
                'constraints' => [new NotBlank()]
                // 'expanded' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
