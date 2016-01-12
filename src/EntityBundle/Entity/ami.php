<?php

namespace EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ami
 *
 * @ORM\Table(name="ami")
 * @ORM\Entity(repositoryClass="EntityBundle\Repository\amiRepository")
 */
class ami
{
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function setUser(User $user)
    {
        $this->user = user;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $friend;

    public function setFriend(User $friend)
    {
        $this->friend = $friend;

        return $this;
    }

    public function getFriend()
    {
        return $this->friend;
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

