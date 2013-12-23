<?php

namespace Drm\BlogBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class Enquiry
{

	/**
	 * @Assert\NotBlank()
	 */
	protected $name;

	/**
	 * @Assert\Email(
	 *     message = "Your email '{{ value }}' is not valid",
	 *     checkMX = true
	 * )
	 */
	protected $email;

	/**
	 * @Assert\Length(
	 *      min = "2",
	 *      max = "50",
	 *      minMessage = "Subject must be at least {{ limit }} characters length",
	 *      maxMessage = "Subject cannot be longer than than {{ limit }} characters length"
	 * )
	 */
	protected $subject;

	/**
	 * @Assert\Length(
	 *      min = "50",
	 *      max = "500",
	 *      minMessage = "Message must be at least {{ limit }} characters length",
	 *      maxMessage = "Message cannot be longer than than {{ limit }} characters length"
	 * )
	 */
	protected $body;

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getSubject()
	{
		return $this->subject;
	}

	public function setSubject($subject)
	{
		$this->subject = $subject;
	}

	public function getBody()
	{
		return $this->body;
	}

	public function setBody($body)
	{
		$this->body = $body;
	}

}
