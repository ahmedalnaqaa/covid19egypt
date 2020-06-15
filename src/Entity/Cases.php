<?php
// src/Entity/Cases.php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use KunicMarko\SonataAnnotationBundle\Annotation as Sonata;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="cases")
 * @Sonata\Admin(label="Cases")
 */
class Cases
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Sonata\ListField()
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_cases", type="bigint", options={"default" = 0})
     * @Sonata\ListField()
     * @Sonata\FormField()
     */
    protected $totalCases = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_recovered", type="bigint", options={"default" = 0})
     * @Sonata\ListField()
     * @Sonata\FormField()
     */
    protected $totalRecovered = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_po_to_ne", type="bigint", options={"default" = 0})
     * @Sonata\ListField()
     * @Sonata\FormField()
     */
    protected $totalPoToNe = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_deaths", type="bigint", options={"default" = 0})
     * @Sonata\ListField()
     * @Sonata\FormField()
     */
    protected $totalDeaths = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_swabs", type="bigint", options={"default" = 0})
     * @Sonata\ListField()
     */
    protected $totalSwabs = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="new_daily_cases", type="integer", options={"default" = 0})
     * @Sonata\ListField()
     * @Sonata\FormField()
     */
    protected $newDailyCases = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="new_daily_recovered", type="integer", options={"default" = 0})
     * @Sonata\ListField()
     */
    protected $newDailyRecovered = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="new_daily_po_to_ne", type="integer", options={"default" = 0})
     * @Sonata\ListField()
     */
    protected $newDailyPoToNe = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="new_daily_deaths", type="integer", options={"default" = 0})
     * @Sonata\ListField()
     * @Sonata\FormField()
     */
    protected $newDailyDeaths = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="new_daily_swabs", type="integer", options={"default" = 0})
     * @Sonata\ListField()
     */
    protected $newDailySwabs = 0;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     * @Sonata\ListField()
     * @Sonata\FormField()
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
     * @return int
     */
    public function getTotalCases(): int
    {
        return $this->totalCases;
    }

    /**
     * @param int $totalCases
     */
    public function setTotalCases(int $totalCases): void
    {
        $this->totalCases = $totalCases;
    }

    /**
     * @return int
     */
    public function getTotalRecovered(): int
    {
        return $this->totalRecovered;
    }

    /**
     * @param int $totalRecovered
     */
    public function setTotalRecovered(int $totalRecovered): void
    {
        $this->totalRecovered = $totalRecovered;
    }

    /**
     * @return int
     */
    public function getTotalPoToNe(): int
    {
        return $this->totalPoToNe;
    }

    /**
     * @param int $totalPoToNe
     */
    public function setTotalPoToNe(int $totalPoToNe): void
    {
        $this->totalPoToNe = $totalPoToNe;
    }

    /**
     * @return int
     */
    public function getTotalDeaths(): int
    {
        return $this->totalDeaths;
    }

    /**
     * @param int $totalDeaths
     */
    public function setTotalDeaths(int $totalDeaths): void
    {
        $this->totalDeaths = $totalDeaths;
    }

    /**
     * @return int
     */
    public function getTotalSwabs(): int
    {
        return $this->totalSwabs;
    }

    /**
     * @param int $totalSwabs
     */
    public function setTotalSwabs($totalSwabs)
    {
        $this->totalSwabs = $totalSwabs;
    }

    /**
     * @return int
     */
    public function getNewDailySwabs()
    {
        return $this->newDailySwabs;
    }

    /**
     * @param int $newDailySwabs
     */
    public function setNewDailySwabs($newDailySwabs)
    {
        $this->newDailySwabs = $newDailySwabs;
    }

    /**
     * @return int
     */
    public function getNewDailyCases(): int
    {
        return $this->newDailyCases;
    }

    /**
     * @param int $newDailyCases
     */
    public function setNewDailyCases(int $newDailyCases): void
    {
        $this->newDailyCases = $newDailyCases;
    }

    /**
     * @return int
     */
    public function getNewDailyRecovered(): int
    {
        return $this->newDailyRecovered;
    }

    /**
     * @param int $newDailyRecovered
     */
    public function setNewDailyRecovered(int $newDailyRecovered): void
    {
        $this->newDailyRecovered = $newDailyRecovered;
    }

    /**
     * @return int
     */
    public function getNewDailyPoToNe(): int
    {
        return $this->newDailyPoToNe;
    }

    /**
     * @param int $newDailyPoToNe
     */
    public function setNewDailyPoToNe(int $newDailyPoToNe): void
    {
        $this->newDailyPoToNe = $newDailyPoToNe;
    }

    /**
     * @return int
     */
    public function getNewDailyDeaths(): int
    {
        return $this->newDailyDeaths;
    }

    /**
     * @param int $newDailyDeaths
     */
    public function setNewDailyDeaths(int $newDailyDeaths): void
    {
        $this->newDailyDeaths = $newDailyDeaths;
    }

    /**
     * Set createdAt
     *
     * @param DateTime $createdAt
     *
     * @return Cases
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