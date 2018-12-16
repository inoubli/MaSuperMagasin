<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(

            ))
            ->add('description', TextareaType::class)
            ->add('surface', IntegerType::class)
            ->add('rooms', IntegerType::class)
            ->add('bedrooms', IntegerType::class)
            ->add('floor', IntegerType::class)
            ->add('price', IntegerType::class)
            ->add('heat', ChoiceType::class, array(
                'choices' => $this->getChoices()
            ))
            ->add('city', null, [
                'label' => 'Ville'
            ])
            ->add('address')
            ->add('postal_code')
            ->add('sold')
           // ->add('created_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
    public function getChoices()
    {
        $choices = Property::HEAT;
        $output= [];
        foreach ($choices as $k => $v)
        {
            $output[$v] = $k;
        }
        return $output;
    }
}
