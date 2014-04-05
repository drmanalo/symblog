<?php

namespace Drm\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

/**
 * Drm\BlogBundle\Entity\User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class User implements UserInterface, \Serializable
{

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=25, unique=true)
	 */
	private $username;

	/**
	 * @ORM\Column(type="string", length=250)
	 */
	private $password;

	/**
	 * @ORM\Column(type="string", length=60, unique=true)
	 */
	private $email;

	/**
	 * @ORM\Column(name="is_active", type="boolean", nullable=false)
	 */
	private $isActive;
	
	private $salt = 'Tee8ahcohTooKio5DaiS';
	
	/**
	 * @ORM\ManyToMany(targetEntity="Role", inversedBy="users")
	 *
	 */
	private $roles;

	public function __construct()
	{
		$this->isActive = true;
		$this->roles = new ArrayCollection();
	}

	/**
	 * @inheritDoc
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @inheritDoc
	 */
	public function getSalt()
	{
		return 'Tee8ahcohTooKio5DaiS';
	}

	/**
	 * @inheritDoc
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @inheritDoc
	 */
	public function getRoles()
	{
	    return $this->roles->toArray();
	}

	/**
	 * @inheritDoc
	 */
	public function eraseCredentials()
	{
	}

	/**
	 *
	 * @see \Serializable::serialize()
	 */
	public function serialize()
	{
		return serialize ( array (
				$this->id,
				$this->username,
				$this->password,
				$this->salt
		) );
	}

	/**
	 *
	 * @see \Serializable::unserialize()
	 */
	public function unserialize($serialized)
	{
		list ( $this->id, $this->username, $this->password, $this->salt ) = unserialize ( $serialized );
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
	 * Set username
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
	 * Set password
	 *
	 * @param string $password        	
	 * @return User
	 */
	public function setPassword($password)
	{
		$encoder = new MessageDigestPasswordEncoder ( 'sha512', false, 10 );
		$password = $encoder->encodePassword ( $password, $this->getSalt () );
		
		$this->password = $password;
	}

	/**
	 * Set email
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
	 * Get email
	 *
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * Set isActive
	 *
	 * @param boolean $isActive        	
	 * @return User
	 */
	public function setIsActive($isActive)
	{
		$this->isActive = $isActive;
		
		return $this;
	}

	/**
	 * Get isActive
	 *
	 * @return boolean
	 */
	public function getIsActive()
	{
		return $this->isActive;
	}
	

    /**
     * Add roles
     *
     * @param \Drm\BlogBundle\Entity\Role $roles
     * @return User
     */
    public function addRole(\Drm\BlogBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;
    
        return $this;
    }

    /**
     * Remove roles
     *
     * @param \Drm\BlogBundle\Entity\Role $roles
     */
    public function removeRole(\Drm\BlogBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }
}