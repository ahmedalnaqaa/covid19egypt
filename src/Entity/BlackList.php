<?php
// src/Entity/Blacklist.php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use KunicMarko\SonataAnnotationBundle\Annotation as Sonata;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="blacklists")
 * @Sonata\Admin(label="Blacklists")
 */
class BlackList
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Sonata\ListField()
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="ip", type="string", length=32, nullable=false)
     * @Sonata\ListField()
     * @Sonata\FormField()
     */
    protected $ip = '';

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Sonata\ListField()
     */
    private $createdAt;

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        if (!$this->getCreatedAt()) {
            $this->setCreatedAt(new \DateTime());
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * Set createdAt
     *
     * @param DateTime $createdAt
     *
     * @return BlackList
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function __toString()
    {
        return $this->getIp();
    }
}