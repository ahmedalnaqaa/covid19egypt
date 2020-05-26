<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SonataAnnotationBundle\Annotation as Sonata;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @Sonata\Admin(label="Messages")
 * @ORM\Table(name="messages")
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Sonata\ListField()
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\Chat", inversedBy="messages")
     * @ORM\JoinColumn(name="chat_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     * @Sonata\ListField()
     * @Sonata\FormField()
     */
    protected $chat;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Entity\User")
     * @ORM\JoinColumn(name="sender_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     * @Sonata\ListField()
     * @Sonata\FormField()
     */
    protected $sender;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="message", type="text", nullable=false)
     * @Sonata\ListField()
     * @Sonata\FormField()
     */
    protected $message = '';

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
     * @return Chat
     */
    public function getChat()
    {
        return $this->chat;
    }

    /**
     * @param Chat $chat
     */
    public function setChat(Chat $chat)
    {
        $this->chat = $chat;
    }

    /**
     * @return User
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param User $sender
     */
    public function setSender(User $sender)
    {
        $this->sender = $sender;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }


    /**
     * Set createdAt
     *
     * @param DateTime $createdAt
     *
     * @return Message
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