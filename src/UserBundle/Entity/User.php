<?php

/**
 * Created by PhpStorm.
 * User: martin
 * Date: 14/03/2017
 * Time: 12:37
 */

namespace UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="funnytrip_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="FunnyTrip\Bundle\Entity\Annonce", mappedBy="user")
     */
    private $annonces;

    /**
     * @ORM\ManyToMany(targetEntity="FunnyTrip\Bundle\Entity\Reservation", mappedBy="users")
     */
    protected $reservations;
    /**
     * @ORM\Column(name="theme", type="integer", options={"default" : 0})
     */
    private $theme;

    /**
     * @return mixed
     */
    public function getAnnonces()
    {
        return $this->annonces;
    }

    /**
     * @param mixed $annonces
     */
    public function setAnnonces($annonces)
    {
        $this->annonces = $annonces;
    }

    /**
     * @return mixed
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * @param mixed $reservations
     */
    public function setReservations($reservations)
    {
        $this->reservations = $reservations;
    }

    /**
     * Set theme
     *
     * @param integer $theme
     * @return User
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return integer
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Add annonces
     *
     * @param \FunnyTrip\Bundle\Entity\Annonce $annonces
     * @return User
     */
    public function addAnnonce(\FunnyTrip\Bundle\Entity\Annonce $annonces)
    {
        $this->annonces[] = $annonces;

        return $this;
    }

    /**
     * Remove annonces
     *
     * @param \FunnyTrip\Bundle\Entity\Annonce $annonces
     */
    public function removeAnnonce(\FunnyTrip\Bundle\Entity\Annonce $annonces)
    {
        $this->annonces->removeElement($annonces);
    }

    /**
     * Add reservations
     *
     * @param \FunnyTrip\Bundle\Entity\Reservation $reservations
     * @return User
     */
    public function addReservation(\FunnyTrip\Bundle\Entity\Reservation $reservations)
    {
        $this->reservations[] = $reservations;

        return $this;
    }

    /**
     * Remove reservations
     *
     * @param \FunnyTrip\Bundle\Entity\Reservation $reservations
     */
    public function removeReservation(\FunnyTrip\Bundle\Entity\Reservation $reservations)
    {
        $this->reservations->removeElement($reservations);
    }
}
