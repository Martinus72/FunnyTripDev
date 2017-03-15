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
   */
  public function trajetAction()
  {
    $em = $this->getDoctrine()->getManager();
    /*$queryBuilder = $em->getRepository('FunnyTripBundle:Annonce')->createQueryBuilder('e');

    list($annonces, $pagerHtml) = $this->paginator($queryBuilder, $request);

    return $this->render('annonce/index.html.twig', array(
      'annonces' => $annonces,
      'pagerHtml' => $pagerHtml,

    ));*/

    $qb = $em->createQueryBuilder();
    $qb->select('a')->from('FunnyTripBundle:Annonce', 'a')->where('a.id = :id')->setParameter('id', $this->getUser());
    $annonces = $qb->getQuery()->getResult();

    return $this->render('FunnyTripBundle:Default:trajet.html.twig', array(
      'annonces' => $annonces,
    ));

}

public
function reservationAction()
{

  return $this->render('FunnyTripBundle:Default:reservation.html.twig',
    array('test' => 'Reservation'));

}

}
