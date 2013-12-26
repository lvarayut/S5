<?php

namespace Enstb\Bundle\VisplatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Roles
 */
class Roles
{
    /**
     * @var integer
     */
    private $Id;

    /**
     * @var string
     */
    private $Name;

    /**
     * @var string
     */
    private $Description;

    /**
     * @var \DateTime
     */
    private $DateCreated;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get Id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->Id;
    }

    /**
     * Set Name
     *
     * @param string $name
     * @return Roles
     */
    public function setName($name)
    {
        $this->Name = $name;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * Set Description
     *
     * @param string $description
     * @return Roles
     */
    public function setDescription($description)
    {
        $this->Description = $description;

        return $this;
    }

    /**
     * Get Description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * Set DateCreated
     *
     * @param \DateTime $dateCreated
     * @return Roles
     */
    public function setDateCreated($dateCreated)
    {
        $this->DateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get DateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->DateCreated;
    }

    /**
     * Add Users
     *
     * @param \Enstb\Bundle\VisplatBundle\Entity\Users $users
     * @return Roles
     */
    public function addUser(\Enstb\Bundle\VisplatBundle\Entity\Users $users)
    {
        $this->Users[] = $users;

        return $this;
    }

    /**
     * Remove Users
     *
     * @param \Enstb\Bundle\VisplatBundle\Entity\Users $users
     */
    public function removeUser(\Enstb\Bundle\VisplatBundle\Entity\Users $users)
    {
        $this->Users->removeElement($users);
    }

    /**
     * Get Users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->Users;
    }
    /**
     * @ORM\PrePersist
     */
    public function setDateCreatedValue()
    {
        $this->setDateCreated(new \DateTime());
    }
}
