<?php

namespace EntityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AttachType
 *
 * @ORM\Table(name="attach_type")
 * @ORM\Entity(repositoryClass="EntityBundle\Repository\AttachTypeRepository")
 */
class AttachType
{

    /**
     * @ORM\ManyToOne(targetEntity="attachment")
     * @ORM\JoinColumn(nullable=false)
     */
    private $attachment;

    public function setAttachment(attachment $attachment)
    {
        $this->attachment = $attachment;

        return $this;
    }

    public function getAttachment()
    {
        return $this->attachment;
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
     * @ORM\Column(name="attach_type_name", type="string", length=32)
     */
    private $attachTypeName;


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
     * Set attachTypeName
     *
     * @param string $attachTypeName
     *
     * @return AttachType
     */
    public function setAttachTypeName($attachTypeName)
    {
        $this->attachTypeName = $attachTypeName;

        return $this;
    }

    /**
     * Get attachTypeName
     *
     * @return string
     */
    public function getAttachTypeName()
    {
        return $this->attachTypeName;
    }
}

