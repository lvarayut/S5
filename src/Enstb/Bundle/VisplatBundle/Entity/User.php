<?php

namespace Enstb\Bundle\VisplatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 */
class User implements UserInterface, \Serializable
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
    private $lastName;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var \DateTime
     */
    private $dateCreated;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $roles;

    /**
     * @var \Enstb\Bundle\VisplatBundle\Entity\Data
     */
    private $data;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return User
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
     * Set LastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get LastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set Email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get Email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set Username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get Username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set Password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get Password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set DateCreated
     *
     * @param \DateTime $dateCreated
     * @return User
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
     * Add Roles
     *
     * @param \Enstb\Bundle\VisplatBundle\Entity\Role $role
     * @return User
     */
    public function addRole(\Enstb\Bundle\VisplatBundle\Entity\Role $role)
    {
        // Link each role with the user
        $role->addUser($this);
        $this->roles->add($role);

        return $this;
    }

    /**
     * Remove Role
     *
     * @param \Enstb\Bundle\VisplatBundle\Entity\Role $role
     */
    public function removeRole(\Enstb\Bundle\VisplatBundle\Entity\Role $role)
    {
        // Link each role with the user
        $role->removeUser($this);
        $this->roles->removeElement($role);
    }

    /**
     * Get Role
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {

    }

    public function equals(User $user)
    {
        return $user->getUsername() == $this->getUsername();
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

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            ) = unserialize($serialized);
    }


    /**
     * Set data
     *
     * @param \Enstb\Bundle\VisplatBundle\Entity\Data $data
     * @return User
     */
    public function setData(\Enstb\Bundle\VisplatBundle\Entity\Data $data = null)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \Enstb\Bundle\VisplatBundle\Entity\Data 
     */
    public function getData()
    {
        return $this->data;
    }
}
