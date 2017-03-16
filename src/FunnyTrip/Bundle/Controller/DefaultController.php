<?php

namespace FunnyTrip\Bundle\Controller;

use FunnyTrip\Bundle\Entity\Annonce;
use FunnyTrip\Bundle\Entity\Reservation;
use GuzzleHttp\Psr7\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class DefaultController extends Controller
{
  public function indexAction()
  {

    return $this->render('FunnyTripBundle:Default:index.html.twig',
      array('nom' => 'Home'));

  }


  /**
   * Affiche les trajets déposé par le user.
   */
  public function trajetAction()
  {

    $annonces = $this->getUser()->getAnnonces();
    return $this->render('FunnyTripBundle:Default:trajet.html.twig', array(
      'annonces' => $annonces,
    ));

  }

  public function reservationAction()
  {
    $resas = $this->getUser()->getReservations();

    return $this->render('FunnyTripBundle:Default:reservation.html.twig', array(
      'resas' => $resas,
    ));
  }

  /**
   * Créer une nouvelle réservation
   */
  public function new_reservationAction()
  {

    $resa_exist = false;

    $repository = $this->getDoctrine()->getManager()->getRepository(('FunnyTripBundle:Annonce'));

    // Get annonce
    $id_annonce = $_GET['id'];
    $array_annonce = $repository->findById($id_annonce);
    $annonce = $array_annonce[0];

    // Get réservations du user
    $reservations = $this->getUser()->getReservations();

    foreach ($reservations as $reservation) {
      if ($reservation->getAnnonce()->getId() == $id_annonce) {
        $resa_exist = true;
      }
    }


    if (!$resa_exist) {
      // On créer l'objet réservation
      $resa = new Reservation();
      $resa->setAnnonce($annonce);
      $resa->addUser($this->getUser());

      $annonce->setReservations($resa);

      $em = $this->getDoctrine()->getManager();
      $em->persist($resa);
      $em->flush();

      $showLink = $this->generateUrl('funny_trip_reservation');
      $this->get('session')->getFlashBag()->add('success', "<a href='$showLink'>Trajet réservé</a>");

      return $this->redirect('annonce/');
    } else {
      $showLink = $this->generateUrl('funny_trip_reservation');
      $this->get('session')->getFlashBag()->add('warning', "<a href='$showLink'>Trajet déjà réservé</a>");

      return $this->redirect('annonce/');
    }


  }
}
