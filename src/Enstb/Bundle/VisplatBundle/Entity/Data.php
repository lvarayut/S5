<?php

namespace Enstb\Bundle\VisplatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Data
 */
class Data
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $event;

    /**
     * @var \DateTime
     */
    private $begin;

    /**
     * @var \DateTime
     */
    private $end;

    /**
     * @var string
     */
    private $place;

    /**
     * @var \Enstb\Bundle\VisplatBundle\Entity\User
     */
    private $patientId;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set event
     *
     * @param string $event
     * @return Data
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return string 
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set begin
     *
     * @param \DateTime $begin
     * @return Data
     */
    public function setBegin($begin)
    {
        $this->begin = $begin;

        return $this;
    }

    /**
     * Get begin
     *
     * @return \DateTime 
     */
    public function getBegin()
    {
        return $this->begin;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     * @return Data
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime 
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set place
     *
     * @param string $place
     * @return Data
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return string 
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set patientId
     *
     * @param \Enstb\Bundle\VisplatBundle\Entity\User $patientId
     * @return Data
     */
    public function setPatientId(\Enstb\Bundle\VisplatBundle\Entity\User $patientId = null)
    {
        $this->patientId = $patientId;

        return $this;
    }

    /**
     * Get patientId
     *
     * @return \Enstb\Bundle\VisplatBundle\Entity\User 
     */
    public function getPatientId()
    {
        return $this->patientId;
    }
}
