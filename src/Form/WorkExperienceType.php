<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\WorkExperience;
use Arkounay\Bundle\UxCollectionBundle\Form\UxCollectionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder->add('company');
        $builder->add('jobTitle');
        $builder->add('startDate', DateType::class);
        $builder->add('endDate', DateType::class, [
            'required' => false,
        ]);

        $builder->add('technologies', UxCollectionType::class, [
            'entry_type' => TextType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'min' => 1,
        ]);

        $builder->add('comment', TextareaType::class);

        $builder->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'entity_class' => WorkExperience::class,
        ]);
    }
}