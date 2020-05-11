<?php
// src/Entity/Test.php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="tests")
 */
class Test
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="data", type="array")
     */
    protected $data;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Location", inversedBy="tests")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    protected $location;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\User", inversedBy="tests")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    protected $user;

    /**
     * @var integer
     *
     * @ORM\Column(name="score", type="smallint", options={"default" = 0})
     */
    protected $score = 0;

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
     * Get id
     *
     * @return Test
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set data
     *
     * @param $data
     *
     * @return Test
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return Test
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set score
     *
     * @param $score
     *
     * @return Test
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get score
     *
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set user
     *
     * @param User $user
     *
     * @return Test
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set location
     *
     * @param Location $location
     *
     * @return Test
     */
    public function setLocation(Location $location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return Location
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Set createdAt
     *
     * @param DateTime $createdAt
     *
     * @return Test
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
}