<?php

namespace App\Form;

use App\Entity\Account;
use App\Entity\Employee;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Heslo',
                'always_empty' => false,
            ])
            ->add('validity', DateType::class, [
                'label' => 'Platnost',
                'format' => DateType::HTML5_FORMAT,
                'html5' => true,
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('employee', EntityType::class, [
                'label' => 'ID zaměstance',
                'class' => Employee::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('b'); //this selects all reviews
                },
                'choice_label' => function($employee){
                    return $employee->getId();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Account::class,
        ]);
    }
}
