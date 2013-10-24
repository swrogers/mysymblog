<?php

namespace Blogger\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="Blogger\UserBundle\Entity\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\ManyToMany(targetEntity="Blogger\UserBundle\Entity\Group")
     * @ORM\JoinTable(name="fos_user_user_group",
                      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
                      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
                      )
    */
    protected $groups;

    /**
     * @ORM\Column(type="string", length="255", unique=true)
     */
    protected $email;

    public function __construct()
    {
      parent::__construct();
    }

    public function __toString()
    {
      return $this->getFullName();
    }

    public function getFullName()
    {
      return $this->firstName . ' ' . $this->lastName;
    }

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
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
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
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Add groups
     *
     * @param \Blogger\UserBundle\Entity\Group $groups
     * @return User
     */
    public function addGroup(\Blogger\UserBundle\Entity\Group $groups)
    {
        $this->groups[] = $groups;
    
        return $this;
    }

    /**
     * Remove groups
     *
     * @param \Blogger\UserBundle\Entity\Group $groups
     */
    public function removeGroup(\Blogger\UserBundle\Entity\Group $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }
}