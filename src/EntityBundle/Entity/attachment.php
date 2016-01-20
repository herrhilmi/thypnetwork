<?php

namespace EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * attachment
 *
 * @ORM\Table(name="attachment")
 * @ORM\Entity(repositoryClass="EntityBundle\Repository\attachmentRepository")
 */
class attachment
{
    /**
     * @ORM\ManyToOne(targetEntity="AttachType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $AttachType;

    public function setAttachType(AttachType $AttachType)
    {
        $this->AttachType = $AttachType;

        return $this;
    }

    public function getAttachType()
    {
        return $this->AttachType;
    }





    /**
     * @ORM\ManyToOne(targetEntity="annonce")
     * @ORM\JoinColumn(nullable=false)
     */
    private $annonce;

    public function setAnnonce(annonce $annonce)
    {
        $this->annonce = $annonce;

        return $this;
    }

    public function getAnnonce()
    {
        return $this->annonce;
    }


    /**
     * @ORM\ManyToOne(targetEntity="message")
     * @ORM\JoinColumn(nullable=false)
     */
    private $message;

    public function setMessage(message $message)
    {
        $this->message = $message;

        return $this;
    }

    public function getMessage()
    {
        return $this->message;
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
     * @ORM\Column(name="srcAttachment", type="string", length=255)
     */
    private $srcAttachment;


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
     * Set srcAttachment
     *
     * @param string $srcAttachment
     *
     * @return attachment
     */
    public function setSrcAttachment($srcAttachment)
    {
        $this->srcAttachment = $srcAttachment;

        return $this;
    }

    /**
     * Get srcAttachment
     *
     * @return string
     */
    public function getSrcAttachment()
    {
        return $this->srcAttachment;
    }
}

