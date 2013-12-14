<?php

namespace Drm\BlogBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="blogs")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Drm\BlogBundle\Entity\Repository\BlogRepository")
 */
class Blog
{

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string")
	 */
	protected $title;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $author;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $blog;

	/**
	 * @ORM\Column(type="string", length=20)
	 */
	protected $image;

	/**
	 * @ORM\Column(type="text")
	 */
	protected $tags;

	/**
	 * @ORM\OneToMany(targetEntity="Comment", mappedBy="blog")
	 */
	protected $comments;

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $created;

	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $updated;

	public function __construct()
	{
		$this->comments = new ArrayCollection();
		
		$this->setCreated(new \DateTime());
		$this->setUpdated(new \DateTime());
	}
	
	public function __toString()
	{
		return $this->getTitle();
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

	public function getAuthor()
	{
		return $this->author;
	}

	public function setAuthor($author)
	{
		$this->author = $author;
	}

	public function getBlog($length = null)
	{
		if (false === is_null($length) && $length > 0)
			return substr($this->blog, 0, $length);
		else
			return $this->blog;
	}

	public function setBlog($blog)
	{
		$this->blog = $blog;
	}

	public function getImage()
	{
		return $this->image;
	}

	public function setImage($image)
	{
		$this->image = $image;
	}

	public function getTags()
	{
		return $this->tags;
	}

	public function setTags($tags)
	{
		$this->tags = $tags;
	}

	public function getComments()
	{
		return $this->comments;
	}

	public function setComments($comments)
	{
		$this->comments = $comments;
	}

	public function getCreated()
	{
		return $this->created;
	}

	public function setCreated($created)
	{
		$this->created = $created;
	}

	public function getUpdated()
	{
		return $this->updated;
	}

	public function setUpdated($updated)
	{
		$this->updated = $updated;
	}

	/**
	 * @ORM\PreUpdate
	 */
	public function setUpdatedValue()
	{
		$this->setUpdated(new \DateTime());
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
     * Add comments
     *
     * @param \Drm\BlogBundle\Entity\Comment $comments
     * @return Blog
     */
    public function addComment(\Drm\BlogBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;
    
        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Drm\BlogBundle\Entity\Comment $comments
     */
    public function removeComment(\Drm\BlogBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }
}