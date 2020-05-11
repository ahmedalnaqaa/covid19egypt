<?php
// src/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="full_name", type="string", length=100, nullable=true)
     */
    protected $fullName;

    /**
     * @var string
     *
     * @Assert\Regex(
     *     pattern="/^[0-9\-\(\)\/\+\s]*$/",
     *     match=true,
     *     message="رقم هاتف غير صحيح"
     * )
     * @ORM\Column(name="phone_number", type="string", length=30, nullable=true)
     */
    protected $phoneNumber;

    /**
     * @var
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @var
     *
     * @ORM\Column(name="symptoms_started_at", type="date", nullable=true)
     */
    private $symptomsStartedAt;

    /**
     * @var
     *
     * @ORM\Column(name="isolation_started_at", type="date", nullable=true)
     */
    private $isolationStartedAt;

    /**
     * @var
     *
     * @ORM\Column(name="isolation_end_at", type="date", nullable=true)
     */
    private $isolationEndAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="gender", type="smallint", options={"default" = 0})
     */
    protected $gender = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_chronic", type="boolean")
     */
    protected $isChronic = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_family_chronic", type="boolean")
     */
    protected $isFamilyChronic = false;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Test", mappedBy="user", fetch="LAZY")
     */
    protected $tests;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Isolation", mappedBy="user", fetch="LAZY")
     */
    protected $isolations;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Location", inversedBy="users")
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    protected $location;

    /**
     * Creates a parent / child relationship on this entity.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User",inversedBy="id")
     * @ORM\JoinColumn(name="assigned_doctor", referencedColumnName="id", nullable=true)
     */
    protected $assignedDoctor = null;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="assignedDoctor")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    protected $children;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    public function __construct()
    {
        parent::__construct();
        $this->tests = new ArrayCollection();
        $this->isolations = new ArrayCollection();
        $this->children = new ArrayCollection();
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
     * Set fullName.
     *
     * @param string $fullName
     *
     * @return User
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName.
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @param \DateTime $birthDate
     * @return $this
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set isChronic
     *
     * @param $isChronic
     * @return $this
     */
    public function setIsChronic($isChronic)
    {
        $this->isChronic = $isChronic;

        return $this;
    }

    /**
     * Is chronic?
     *
     * @return bool
     */
    public function isChronic()
    {
        return $this->isChronic;
    }

    /**
     * Set isFamilyChronic
     *
     * @param $isFamilyChronic
     * @return $this
     */
    public function setIsFamilyChronic($isFamilyChronic)
    {
        $this->isFamilyChronic = $isFamilyChronic;

        return $this;
    }

    /**
     * Is family chronic?
     *
     * @return bool
     */
    public function isFamilyChronic()
    {
        return $this->isFamilyChronic;
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

    /**
     * Get isolations
     *
     * @return ArrayCollection
     */
    public function getIsolations()
    {
        return $this->isolations;
    }

    /**
     * Set symptomsStartedAt
     *
     * @param /Date $symptomsStartedAt
     *
     * @return User
     */
    public function setSymptomsStartedAt($symptomsStartedAt)
    {
        $this->symptomsStartedAt = $symptomsStartedAt;

        return $this;
    }

    /**
     * Get symptomsStartedAt
     *
     * @return  /DateTime
     */
    public function getSymptomsStartedAt()
    {
        return $this->symptomsStartedAt;
    }

    /**
     * Set isolationStartedAt
     *
     * @param /Date $isolationStartedAt
     *
     * @return User
     */
    public function setIsolationStartedAt($isolationStartedAt)
    {
        $this->isolationStartedAt = $isolationStartedAt;

        return $this;
    }

    /**
     * Get isolationStartedAt
     *
     * @return  /DateTime
     */
    public function getIsolationStartedAt()
    {
        return $this->isolationStartedAt;
    }

    /**
     * Set isolationEndAt
     *
     * @param /Date $isolationEndAt
     *
     * @return User
     */
    public function setIsolationEndAt($isolationEndAt)
    {
        $this->isolationEndAt = $isolationEndAt;

        return $this;
    }

    /**
     * Get isolationEndAt
     *
     * @return  /DateTime
     */
    public function getIsolationEndAt()
    {
        return $this->isolationEndAt;
    }

    /**
     * Set location
     *
     * @param Location $location
     *
     * @return User
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
     * @return null
     */
    public function getAssignedDoctor()
    {
        return $this->assignedDoctor;
    }

    /**
     * @param null $assignedDoctor
     */
    public function setAssignedDoctor($assignedDoctor): void
    {
        $this->assignedDoctor = $assignedDoctor;
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}