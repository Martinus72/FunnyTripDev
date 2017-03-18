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


  /**
   * Affiche les réservations du user
   */
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

    //Nombre de places restantes
    $nb_places_prise = $annonce->getNbPlacePrise();
    $nb_places_max = $annonce->getNbPlaceMax();

    $nb_places = $nb_places_max - $nb_places_prise;

    // Get réservations du user
    $reservations = $this->getUser()->getReservations();

    foreach ($reservations as $reservation) {
      if ($reservation->getAnnonce()->getId() == $id_annonce) {
        $resa_exist = true;
      }
    }


    if (!$resa_exist && $nb_places > 0) {
      // On créer l'objet réservation
      $resa = new Reservation();
      $resa->setAnnonce($annonce);
      $resa->addUser($this->getUser());

      $annonce->setNbPlacePrise($nb_places_prise + 1);

      $em = $this->getDoctrine()->getManager();
      $em->persist($resa);
      $em->persist($annonce);
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

  /**
   * Supprime une réservation
   */
  public function delete_reservationAction()
  {

    $repository = $this->getDoctrine()->getManager()->getRepository(('FunnyTripBundle:Reservation'));

    // Get reservation
    $id_resa = $_GET['id'];
    $array_resa = $repository->findById($id_resa);
    $resa = $array_resa[0];

    $annonce = $resa->getAnnonce();

    $nb_places_prise = $annonce->getNbPlacePrise();

    $annonce->setNbPlacePrise($nb_places_prise - 1);


    // Remove réservations du user
    $this->getUser()->removeReservation($resa);

    $em = $this->getDoctrine()->getManager();
    $em->remove($resa);
    $em->persist($annonce);
    $em->flush();

    return $this->redirect('mes_reservations');

  }

}
