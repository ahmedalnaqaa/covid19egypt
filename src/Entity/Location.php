<?php
// src/Entity/Location.php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use KunicMarko\SonataAnnotationBundle\Annotation as Sonata;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="locations")
 * @Sonata\Admin(label="Locations")
 */
class Location
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
     * @ORM\Column(name="title", type="string", length=100, nullable=true)
     * @Sonata\ListField()
     * @Sonata\FormField()
     */
    protected $title = '';

    /**
     * Creates a parent / child relationship on this entity.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Location",inversedBy="id")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     * @Sonata\ListField()
     * @Sonata\FormField()
     */
    protected $parent = null;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Test", mappedBy="location", fetch="LAZY")
     */
    protected $tests;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Sonata\ListField()
     */
    private $createdAt;

    public function __construct()
    {
        $this->tests = new ArrayCollection();
    }

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
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return null
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param null $parent
     */
    public function setParent($parent): void
    {
        $this->parent = $parent;
    }

    /**
     * Set createdAt
     *
     * @param DateTime $createdAt
     *
     * @return Location
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

    /**
     * Get tests
     *
     * @return ArrayCollection
     */
    public function getTests()
    {
        return $this->tests;
    }

    public function __toString()
    {
       return $this->getTitle();
    }
}