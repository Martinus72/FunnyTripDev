<?php

namespace FunnyTrip\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


/**
 * Annonce
 *
 * @ORM\Table(name="annonce")
 * @ORM\Entity(repositoryClass="FunnyTrip\Bundle\Repository\AnnonceRepository")
 */
class Annonce
{

  /**
   * ID du conducteur
   *
   * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
   * @ORM\JoinColumn(nullable=false)
   */
  private $user;


  /**
   * @var int
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @var \DateTime
   *
   * @ORM\Column(name="date", type="datetime")
   */
  private $date;


  /**
   * @var \DateTime
   *
   * @ORM\Column(name="date_depart", type="datetime")
   */
  private $dateDepart;

  /**
   * @var string
   *
   * @ORM\Column(name="ville_depart", type="string", length=255)
   */
  private $villeDepart;

  /**
   * @var string
   *
   * @ORM\Column(name="ville_arrivee", type="string", length=255)
   */
  private $villeArrivee;

  /**
   * @var int
   *
   * @ORM\Column(name="prix", type="integer")
   */
  private $prix;

  /**
   * @var int
   *
   * @ORM\Column(name="nb_place_max", type="integer")
   */
  private $nbPlaceMax;

  /**
   * @var string
   *
   * @ORM\Column(name="description", type="text")
   */
  private $description;


  /*
   * Constructeur
   * */
  public function __construct()
  {
    $this->date = new \Datetime();

  }

  /**
   * Get id
   *
   * @return integer
   */
  public function getId()
  {
    return $this->id;
  }

  /**
 * Set date
 *
 * @param \DateTime $date
 * @return Annonce
 */
  public function setDate($date)
  {
    $this->date = $date;

    return $this;
  }

  /**
   * Get date
   *
   * @return \DateTime
   */
  public function getDate()
  {
    return $this->date;
  }

  /**
   * Set dateDepart
   *
   * @param \DateTime $dateDepart
   * @return Annonce
   */
  public function setDateDepart($dateDepart)
  {
    $this->dateDepart = $dateDepart;

    return $this;
  }

  /**
   * Get dateDepart
   *
   * @return \DateTime
   */
  public function getDateDepart()
  {
    return $this->dateDepart;
  }

  /**
   * Set villeDepart
   *
   * @param string $villeDepart
   * @return Annonce
   */
  public function setVilleDepart($villeDepart)
  {
    $this->villeDepart = $villeDepart;

    return $this;
  }

  /**
   * Get villeDepart
   *
   * @return string
   */
  public function getVilleDepart()
  {
    return $this->villeDepart;
  }

  /**
   * Set villeArrivee
   *
   * @param string $villeArrivee
   * @return Annonce
   */
  public function setVilleArrivee($villeArrivee)
  {
    $this->villeArrivee = $villeArrivee;

    return $this;
  }

  /**
   * Get villeArrivee
   *
   * @return string
   */
  public function getVilleArrivee()
  {
    return $this->villeArrivee;
  }

  /**
   * Set prix
   *
   * @param integer $prix
   * @return Annonce
   */
  public function setPrix($prix)
  {
    $this->prix = $prix;

    return $this;
  }

  /**
   * Get prix
   *
   * @return integer
   */
  public function getPrix()
  {
    return $this->prix;
  }

  /**
   * Set nbPlaceMax
   *
   * @param integer $nbPlaceMax
   * @return Annonce
   */
  public function setNbPlaceMax($nbPlaceMax)
  {
    $this->nbPlaceMax = $nbPlaceMax;

    return $this;
  }

  /**
   * Get nbPlaceMax
   *
   * @return integer
   */
  public function getNbPlaceMax()
  {
    return $this->nbPlaceMax;
  }

  /**
   * Set description
   *
   * @param string $description
   * @return Annonce
   */
  public function setDescription($description)
  {
    $this->description = $description;

    return $this;
  }

  /**
   * Get description
   *
   * @return string
   */
  public function getDescription()
  {
    return $this->description;
  }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     * @return Annonce
     */
    public function setUser(\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
