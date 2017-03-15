<?php

namespace FunnyTrip\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
  public function indexAction()
  {

    return $this->render('FunnyTripBundle:Default:index.html.twig',
      array('nom' => 'Home'));

  }

  public function trajetAction()
  {

    return $this->render('FunnyTripBundle:Default:trajet.html.twig',
      array('test' => 'Trajet'));

  }

  public function reservationAction()
  {

    return $this->render('FunnyTripBundle:Default:reservation.html.twig',
      array('test' => 'Reservation'));

  }

}
