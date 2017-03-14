<?php
/**
 * Created by PhpStorm.
 * User: martin
 * Date: 12/03/2017
 * Time: 16:48
 */

namespace FunnyTrip\Bundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DatePickerType extends AbstractType
{
  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      'widget' => 'single_text'
    ));
  }
  public function getParent()
  {
    return 'date';
  }

  public function getName()
  {
    return 'datePicker';
  }
}