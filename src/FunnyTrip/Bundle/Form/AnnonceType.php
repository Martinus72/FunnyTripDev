<?php

namespace FunnyTrip\Bundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class AnnonceType extends AbstractType
{
  /**
   * @param FormBuilderInterface $builder
   * @param array $options
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      /*->add('date')*/
      ->add('dateDepart', DateTimeType::class, array(
        'data' => new \DateTime()
      ))
      /*->add('dateArrivee')*/
      ->add('villeDepart')
      ->add('villeArrivee')
      ->add('prix')
      ->add('nbPlacePrise')
      ->add('nbPlaceMax')
      ->add('description');
  }

  /**
   * @param OptionsResolver $resolver
   */
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'data_class' => 'FunnyTrip\Bundle\Entity\Annonce'
    ));
  }
}
