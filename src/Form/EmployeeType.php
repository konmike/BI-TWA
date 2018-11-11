<?php

namespace App\Form;

use App\Entity\Employee;
use App\Entity\Role;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', TextType::class, [
                'label' => 'Jméno'
            ])
            ->add('surname', TextType::class, [
                'label' => 'Příjmení'
            ])
            ->add('functions', EntityType::class, [
                'label' => 'Funkce',
                'class' => Role::class,
                'multiple' => true,
            ])
            ->add('room', IntegerType::class, [
                'label' => 'Místnost č.'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email'
            ])
            ->add('phone', TelType::class, [
                'label' => 'Telefon'
            ])
            ->add('web', UrlType::class, [
                'label' => 'Web'
            ])
            ->add('otherInfo', TextareaType::class, [
                'label' => 'Popis'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}
