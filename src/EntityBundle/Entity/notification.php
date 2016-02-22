<?php

namespace EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="EntityBundle\Repository\notificationRepository")
 */
class notification
{
    /**
     * @ORM\ManyToOne(targetEntity="typeNotif")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeNotif;

    public function setTypeNotif(typeNotif $typeNotif)
    {
        $this->typeNotif = $typeNotif;

        return $this;
    }

    public function getTypeNotif()
    {
        return $this->typeNotif;
    }

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $to;

    public function setTo(User $to)
    {
        $this->to = $to;

        return $this;
    }

    public function getTo()
    {
        return $this->to;
    }

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $from;

    public function setFrom(User $from)
    {
        $this->from = $from;

        return $this;
    }

    public function getFrom()
    {
        return $this->from;
    }

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
     * @ORM\Column(name="seen", type="string", length=255)
     */
    private $seen;


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
     * Set seen
     *
     * @param string $seen
     *
     * @return notification
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;

        return $this;
    }

    /**
     * Get seen
     *
     * @return string
     */
    public function getSeen()
    {
        return $this->seen;
    }
}

