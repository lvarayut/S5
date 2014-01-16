<?php

namespace Enstb\Bundle\VisplatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Roles
 */
class Role implements RoleInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $dateCreated;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get Id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Name
     *
     * @param string $name
     * @return Role
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Description
     *
     * @param string $description
     * @return Role
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get Description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set DateCreated
     *
     * @param \DateTime $dateCreated
     * @return Role
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get DateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Add User
     *
     * @param \Enstb\Bundle\VisplatBundle\Entity\User $user
     * @return Role
     */
    public function addUser(\Enstb\Bundle\VisplatBundle\Entity\User $user)
    {
        $this->users->add($user);

        return $this;
    }

    /**
     * Remove User
     *
     * @param \Enstb\Bundle\VisplatBundle\Entity\User $user
     */
    public function removeUser(\Enstb\Bundle\VisplatBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get User
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
    /**
     * @ORM\PrePersist
     */
    public function setDateCreatedValue()
    {
        $this->setDateCreated(new \DateTime());
    }

    function __toString()
    {
        return $this->getName();
    }

    public function getRole(){
        return $this->getName();
    }
}
