<?php

namespace Drm\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Drm\BlogBundle\Entity\User;

class UserFixtures extends AbstractFixture implements OrderedFixtureInterface
{

	public function load(ObjectManager $manager)
	{
		$user2 = new User ();
		$user2->setUsername ( "admin" );
		$user2->setPassword ( "admin" );
		$user2->setEmail ( "admin@example.com" );
		$manager->persist ( $user2 );
		
		$manager->flush ();
	}

	public function getOrder()
	{
		return 3;
	}
}