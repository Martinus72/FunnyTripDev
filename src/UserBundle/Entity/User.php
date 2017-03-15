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
     * @ORM\ManyToMany(targetEntity="FunnyTrip\Bundle\Entity\Reservation", mappedBy="user")
     */
    protected $reservations;

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
}