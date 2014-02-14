<?php

namespace Enstb\Bundle\VisplatBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Enstb\Bundle\VisplatBundle\EnstbVisplatBundle;
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
     * @var \Enstb\Bundle\VisplatBundle\Entity\User
     */
    private $doctorId;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $patients;

    /**
     * Constructor
     */

    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->patients = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add Role
     *
     * @param \Enstb\Bundle\VisplatBundle\Entity\Role $role
     * @return User
     */
    public function addRole(\Enstb\Bundle\VisplatBundle\Entity\Role $role)
    {
        if(!in_array($role,$this->getRoles())){
            // Link each role with the user
            $role->addUser($this);
            $this->roles->add($role);
        }

        return $this;
    }

    /**
     * Add RolesCollection
     *
     * @param $role \Enstb\Bundle\VisplatBundle\Entity\Role $role
     */
    public function addRolesCollection($role){
        $this->addRole($role);
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
     * Remove RolesCollection
     *
     * @param $role \Enstb\Bundle\VisplatBundle\Entity\Role $role
     */
    public function removeRolesCollection($role){
        $this->removeRole($role);
    }

    /**
     * Get Roles array used for Authentication
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }


    /**
     * Get RolesCollection
     *
     * Get Roles array used in case of using SonataAdminBundle
     *
     * @return \Doctrine\Common\Collections\ArrayCollection|\Doctrine\Common\Collections\Collection
     */
    public function getRolesCollection()
    {
        return $this->roles;
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

    /**
     * Set RolesCollection
     *
     * Set roles submitted from SonataAdminBundle form
     * @param $roles \Enstb\Bundle\VisplatBundle\Entity\Role $role
     * @return $user
     */
    public function setRolesCollection($roles)
    {
        if (count($roles) > 0) {
            foreach ($roles as $role) {
                $this->addRole($role);
            }
        }
        return $this;
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
//            $this->roles
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
//            $this->roles
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


    /**
     * Set doctorId
     *
     * @param integer $doctorId
     * @return User
     */
    public function setDoctorId($doctor)
    {
        $this->doctorId = $doctor;
        return $this;
    }

    /**
     * Get doctorId
     *
     * @return integer
     */
    public function getDoctorId()
    {
        return $this->doctorId;
    }

    /**
     * @param int $patient
     *
     * @return integer
     */
    public function setPatients($patientId)
    {
        $this->patients->add($patientId);
        return $this;
    }

    /**
     * @return int
     */
    public function getPatients()
    {
        return $this->patients;
    }


}
