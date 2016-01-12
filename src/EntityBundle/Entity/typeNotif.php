<?php

namespace EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * typeNotif
 *
 * @ORM\Table(name="type_notif")
 * @ORM\Entity(repositoryClass="EntityBundle\Repository\typeNotifRepository")
 */
class typeNotif
{



    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="typeNotif", type="string", length=255)
     */
    private $typeNotif;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set typeNotif
     *
     * @param string $typeNotif
     *
     * @return typeNotif
     */
    public function setTypeNotif($typeNotif)
    {
        $this->typeNotif = $typeNotif;

        return $this;
    }

    /**
     * Get typeNotif
     *
     * @return string
     */
    public function getTypeNotif()
    {
        return $this->typeNotif;
    }
}

