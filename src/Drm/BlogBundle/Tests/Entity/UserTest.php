<?php

namespace Drm\BlogBundle\Tests\Entity;

use Drm\BlogBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class UserTest extends \PHPUnit_Framework_TestCase
{

	public function testSetPassword()
	{
		$user = new User ();
		
		$encoder = new MessageDigestPasswordEncoder ( 'sha512', false, 10 );
		$password = $encoder->encodePassword ( 'admin', $user->getSalt () );
		$user->setPassword ( $password );
		
		$expected = 'cee5aef03a8671b4acdc0403c090d311317eca393b894f9b42c2d8ce0ebe2ff93721af725be2a085087c5e288beb5ddd706bb716132f0a0cfb5edcfeb161ab8f';
		
		$this->assertEquals ( $expected, $user->getPassword () );
	}
}