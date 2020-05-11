<?php
// src/Entity/Isolation.php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use KunicMarko\SonataAnnotationBundle\Annotation as Sonata;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="isolations")
 * @Sonata\Admin(label="Isolations")
 */
class Isolation
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Sonata\ListField()
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\User", inversedBy="isolation")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE", nullable=true)
     */
    protected $user;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="temperature", type="float", length=30, nullable=true)
     * @Sonata\ListField()
     * @Sonata\FormField()
     */
    protected $temperature;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="blood_pressure", type="string", length=30, nullable=true)
     * @Sonata\ListField()
     * @Sonata\FormField()
     */
    protected $bloodPressure;

    /**
     * @var bool
     *
     * @ORM\Column(name="body_ache", type="boolean")
     */
    protected $bodyAche = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="diarrhea", type="boolean")
     */
    protected $diarrhea = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="headache", type="boolean")
     */
    protected $headache = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="lose_of_taste", type="boolean")
     */
    protected $loseOfTaste = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="cough", type="boolean")
     */
    protected $cough = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="sore_throat", type="boolean")
     */
    protected $soreThroat = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="runny_nose", type="boolean")
     */
    protected $runnyNose = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="dyspnea", type="boolean")
     */
    protected $dyspnea = false;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="describe_your_case", type="text", nullable=false)
     * @Sonata\ListField()
     * @Sonata\FormField()
     */
    protected $describeYourCase = '';

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="doctor_comment", type="text", nullable=true)
     * @Sonata\ListField()
     * @Sonata\FormField()
     */
    protected $doctorComment = '';

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Sonata\ListField()
     */
    private $createdAt;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * @param string $temperature
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;
    }

    /**
     * @return string
     */
    public function getBloodPressure()
    {
        return $this->bloodPressure;
    }

    /**
     * @param string $bloodPressure
     */
    public function setBloodPressure($bloodPressure)
    {
        $this->bloodPressure = $bloodPressure;
    }

    /**
     * @return bool
     */
    public function isBodyAche(): bool
    {
        return $this->bodyAche;
    }

    /**
     * @param bool $bodyAche
     */
    public function setBodyAche(bool $bodyAche): void
    {
        $this->bodyAche = $bodyAche;
    }

    /**
     * @return bool
     */
    public function isDiarrhea(): bool
    {
        return $this->diarrhea;
    }

    /**
     * @param bool $diarrhea
     */
    public function setDiarrhea(bool $diarrhea): void
    {
        $this->diarrhea = $diarrhea;
    }

    /**
     * @return bool
     */
    public function isHeadache(): bool
    {
        return $this->headache;
    }

    /**
     * @param bool $headache
     */
    public function setHeadache(bool $headache): void
    {
        $this->headache = $headache;
    }

    /**
     * @return bool
     */
    public function isLoseOfTaste(): bool
    {
        return $this->loseOfTaste;
    }

    /**
     * @param bool $loseOfTaste
     */
    public function setLoseOfTaste(bool $loseOfTaste): void
    {
        $this->loseOfTaste = $loseOfTaste;
    }

    /**
     * @return bool
     */
    public function isCough(): bool
    {
        return $this->cough;
    }

    /**
     * @param bool $cough
     */
    public function setCough(bool $cough): void
    {
        $this->cough = $cough;
    }

    /**
     * @return bool
     */
    public function isDyspnea(): bool
    {
        return $this->dyspnea;
    }

    /**
     * @param bool $dyspnea
     */
    public function setDyspnea(bool $dyspnea): void
    {
        $this->dyspnea = $dyspnea;
    }

    /**
     * @return bool
     */
    public function isSoreThroat(): bool
    {
        return $this->soreThroat;
    }

    /**
     * @param bool $soreThroat
     */
    public function setSoreThroat(bool $soreThroat): void
    {
        $this->soreThroat = $soreThroat;
    }

    /**
     * @return bool
     */
    public function isRunnyNose(): bool
    {
        return $this->runnyNose;
    }

    /**
     * @param bool $runnyNose
     */
    public function setRunnyNose(bool $runnyNose): void
    {
        $this->runnyNose = $runnyNose;
    }

    /**
     * @return string
     */
    public function getDescribeYourCase()
    {
        return $this->describeYourCase;
    }

    /**
     * @param string $describeYourCase
     */
    public function setDescribeYourCase(string $describeYourCase): void
    {
        $this->describeYourCase = $describeYourCase;
    }

    /**
     * @return string
     */
    public function getDoctorComment()
    {
        return $this->doctorComment;
    }

    /**
     * @param string $doctorComment
     */
    public function setDoctorComment(string $doctorComment): void
    {
        $this->doctorComment = $doctorComment;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
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

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        if (!$this->getCreatedAt()) {
            $this->setCreatedAt(new \DateTime());
        }
    }
}