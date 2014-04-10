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
		$password = $encoder->encodePassword ( '123123', $user->getSalt () );
		$user->setPassword ( $password );
		
		$actual = '653c2252276ca438d89eca2e62c70441cd738d7b17f2f679c5aa91228f851c5cb5c254c6235a0d17006244760354557e545e5b972f78a2df1bed011bc491f447';
		
		$this->assertEquals ( $actual, $user->getPassword () );
	}
}