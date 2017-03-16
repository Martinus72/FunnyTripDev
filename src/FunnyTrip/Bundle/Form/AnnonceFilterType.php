<?php

namespace FunnyTrip\Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;


class AnnonceFilterType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('id', Filters\NumberFilterType::class)
      /*->add('date', Filters\DateTimeFilterType::class)*/
      ->add('dateDepart', Filters\DateTimeRangeFilterType::class, array('label' => null, 'left_datetime_options' => array('label' =>'Entre le'), 'right_datetime_options' => array('label' =>'et le')))
      /*->add('dateArrivee', Filters\DateTimeFilterType::class)*/
      ->add('villeDepart', Filters\TextFilterType::class)
      ->add('villeArrivee', Filters\TextFilterType::class)
      ->add('prix', Filters\NumberFilterType::class)
      ->add('nbPlaceMax', Filters\NumberFilterType::class)
      ->add('description', Filters\TextFilterType::class);
    $builder->setMethod("GET");


  }

  public function getBlockPrefix()
  {
    return null;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'allow_extra_fields' => true,
      'csrf_protection' => false,
      'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
    ));
  }
}
