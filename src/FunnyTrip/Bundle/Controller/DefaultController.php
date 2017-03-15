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


  /**
   * Affiche les trajets proposé par le user.
   *
   * @Route("/{id}", name="annonce_show")
   * @Method("GET")
   */
  public function trajetAction(Annonce $annonce)
  {
    $deleteForm = $this->createDeleteForm($annonce);
    return $this->render('FunnyTripBundle:Default:reservation.html.twig', array(
      'annonce' => $annonce,
      'delete_form' => $deleteForm->createView(),
    ));
  }

  public function reservationAction()
  {

    return $this->render('FunnyTripBundle:Default:reservation.html.twig',
      array('test' => 'Reservation'));

  }

}
