<?php

namespace Enstb\Bundle\VisplatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 */
class Users
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
    private $LastName;

    /**
     * @var string
     */
    private $Email;

    /**
     * @var string
     */
    private $Username;

    /**
     * @var string
     */
    private $Password;

    /**
     * @var \DateTime
     */
    private $DateCreated;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $Roles;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Roles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Users
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
     * Set LastName
     *
     * @param string $lastName
     * @return Users
     */
    public function setLastName($lastName)
    {
        $this->LastName = $lastName;

        return $this;
    }

    /**
     * Get LastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->LastName;
    }

    /**
     * Set Email
     *
     * @param string $email
     * @return Users
     */
    public function setEmail($email)
    {
        $this->Email = $email;

        return $this;
    }

    /**
     * Get Email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * Set Username
     *
     * @param string $username
     * @return Users
     */
    public function setUsername($username)
    {
        $this->Username = $username;

        return $this;
    }

    /**
     * Get Username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->Username;
    }

    /**
     * Set Password
     *
     * @param string $password
     * @return Users
     */
    public function setPassword($password)
    {
        $this->Password = $password;

        return $this;
    }

    /**
     * Get Password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->Password;
    }

    /**
     * Set DateCreated
     *
     * @param \DateTime $dateCreated
     * @return Users
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
     * Add Roles
     *
     * @param \Enstb\Bundle\VisplatBundle\Entity\Roles $roles
     * @return Users
     */
    public function addRole(\Enstb\Bundle\VisplatBundle\Entity\Roles $role)
    {
        // Link each role with the user
        $role->addUser($this);
        $this->Roles->add($role);

        return $this;
    }

    /**
     * Remove Roles
     *
     * @param \Enstb\Bundle\VisplatBundle\Entity\Roles $role
     */
    public function removeRole(\Enstb\Bundle\VisplatBundle\Entity\Roles $role)
    {
        // Link each role with the user
        $role->removeUser($this);
        $this->Roles->removeElement($role);
    }

    /**
     * Get Roles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoles()
    {
        return $this->Roles;
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


}
