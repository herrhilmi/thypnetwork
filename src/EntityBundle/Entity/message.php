<?php

namespace EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="EntityBundle\Repository\messageRepository")
 */
class message
{

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
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="object", type="string", length=255)
     */
    private $object;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSet", type="date")
     */
    private $dateSet;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateReaded", type="date")
     */
    private $dateReaded;


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
     * Set content
     *
     * @param string $content
     *
     * @return message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set dateSet
     *
     * @param \DateTime $dateSet
     *
     * @return message
     */
    public function setDateSet($dateSet)
    {
        $this->dateSet = $dateSet;

        return $this;
    }

    /**
     * Get dateSet
     *
     * @return \DateTime
     */
    public function getDateSet()
    {
        return $this->dateSet;
    }

    /**
     * Set dateReaded
     *
     * @param string $dateReaded
     *
     * @return message
     */
    public function setDateReaded($datereaded)
    {
        $this->dateReaded = $datereaded;

        return $this;
    }

    /**
     * Get dateReaded
     *
     * @return \DateTime
     */
    public function getDateReaded()
    {
        return $this->dateReaded;
    }
    /**
     * Set object
     *
     * @param string $object
     *
     * @return Person
     */
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Get object
     *
     * @return string
     */
    public function getObject()
    {
        return $this->object;
    }
}

