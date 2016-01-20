<?php

namespace EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * annonce
 *
 * @ORM\Table(name="annonce")
 * @ORM\Entity(repositoryClass="EntityBundle\Repository\annonceRepository")
 */
class annonce
{

    /**
     * @ORM\OneToMany(targetEntity="comment", mappedBy="annonce")
     */
    private $comments;

    public function getComments()
    {
        return $this->comments;
    }


    /**
     * @ORM\OneToMany(targetEntity="attachment", mappedBy="annonce")
     */
    private $attachments;
    /**
     * @ORM\OneToMany(targetEntity="message", mappedBy="annonce")
     */
    private $messages;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="isVisible", type="string", length=1)
     */
    private $isVisible;


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
     * @return annonce
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return annonce
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
     * Set isVisible
     *
     * @param string $isVisible
     *
     * @return annonce
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * Get isVisible
     *
     * @return string
     */
    public function getIsVisible()
    {
        return $this->isVisible;
    }

    public function getAttachments()
    {
        return $this->attachments;
    }
    public function getMessages()
    {
        return $this->messages;
    }

}

