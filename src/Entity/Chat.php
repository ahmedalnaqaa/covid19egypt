<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SonataAnnotationBundle\Annotation as Sonata;


/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @Sonata\Admin(label="Chat")
 * @ORM\Table(name="chats")
 */
class Chat
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Sonata\ListField()
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\User")
     * @ORM\JoinColumn(name="doctor_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     * @Sonata\ListField()
     * @Sonata\FormField()
     */
    protected $doctor;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\User")
     * @ORM\JoinColumn(name="patient_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     * @Sonata\ListField()
     * @Sonata\FormField()
     */
    protected $patient;

    /**
     * @ORM\OneToMany(targetEntity="\App\Entity\Message", mappedBy="chat", fetch="LAZY")
     * @ORM\OrderBy({"createdAt" = "DESC"})
     */
    protected $messages;

    /**
     * @var DateTime
     * @Sonata\ListField()
     * @Sonata\FormField()
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
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

    public function __construct()
    {
        $this->messages = new ArrayCollection();
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
     * Set patient
     *
     * @param User $doctor
     *
     * @return Chat
     */
    public function setDoctor(User $doctor)
    {
        $this->doctor = $doctor;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getDoctor()
    {
        return $this->doctor;
    }

    /**
     * Set patient
     *
     * @param User $patient
     *
     * @return Chat
     */
    public function setPatient(User $patient)
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * Get messages
     *
     * @return ArrayCollection
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Set createdAt
     *
     * @param DateTime $createdAt
     *
     * @return Chat
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