<?php

namespace App\Filter;

use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextFilterType::class);
    }

    public function getBlockPrefix(): string
    {
        return 'project_filter_type';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                                   'csrf_protection'   => false,
                                   'validation_groups' => array('filtering')
                               ]);
    }
}
