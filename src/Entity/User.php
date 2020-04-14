<?php
// src/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
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
     * @var
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="birth_date", type="date", nullable=true)
     */
    private $birthDate;

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

//    /**
//     * @var bool
//     *
//     * @ORM\Column(name="take_asteroids", type="boolean")
//     */
//    protected $takeAsteroids = false;
//
//    /**
//     * @var bool
//     *
//     * @ORM\Column(name="take_immunosuppressants", type="boolean")
//     */
//    protected $takeImmunosuppressants = false;
//
//    /**
//     * @var bool
//     *
//     * @ORM\Column(name="is_smoking", type="boolean")
//     */
//    protected $isSmoking = false;
//
//    /**
//     * @var int
//     *
//     * @ORM\Column(name="work_area", type="smallint", options={"default" = 0})
//     */
//    private $workArea = 0;

    public function __construct()
    {
        parent::__construct();
        $this->tests = new ArrayCollection();
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
//
//    /**
//     * Set gender.
//     *
//     * @param bool $gender
//     *
//     * @return User
//     */
//    public function setGender($gender)
//    {
//        $this->gender = $gender;
//
//        return $this;
//    }
//
//    /**
//     * Get gender.
//     *
//     * @return int
//     */
//    public function getGender()
//    {
//        return $this->gender;
//    }
//
//    /**
//     * Set takeAsteroids
//     *
//     * @param $takeAsteroids
//     * @return $this
//     */
//    public function setIsTakeAsteroids($takeAsteroids)
//    {
//        $this->isFamilyChronic = $takeAsteroids;
//
//        return $this;
//    }
//
//    /**
//     * Is taking asteroids?
//     *
//     * @return bool
//     */
//    public function hasTakeAsteroids()
//    {
//        return $this->takeAsteroids;
//    }
//
//    /**
//     * Set takeImmunosuppressants
//     *
//     * @param $takeImmunosuppressants
//     * @return $this
//     */
//    public function setHasTakeImmunosuppressants($takeImmunosuppressants)
//    {
//        $this->takeImmunosuppressants = $takeImmunosuppressants;
//
//        return $this;
//    }
//
//    /**
//     * Is taking Immunosuppressants?
//     *
//     * @return bool
//     */
//    public function hasTakeImmunosuppressants()
//    {
//        return $this->takeImmunosuppressants;
//    }
//
//    /**
//     * Set isSmoking
//     *
//     * @param $isSmoking
//     * @return this
//     */
//    public function setIsSmoking($isSmoking)
//    {
//        $this->isSmoking = $isSmoking;
//
//        return $this;
//    }
//
//    /**
//     * Is smoking?
//     *
//     * @return bool
//     */
//    public function isSmoking()
//    {
//        return $this->isSmoking;
//    }
//
//    /**
//     * Set work area.
//     *
//     * @param string $workArea
//     *
//     * @return User
//     */
//    public function setWorkArea($workArea)
//    {
//        $this->workArea = $workArea;
//
//        return $this;
//    }
//
//    /**
//     * Get work area.
//     *
//     * @return string
//     */
//    public function getWorkArea()
//    {
//        return $this->workArea;
//    }
}