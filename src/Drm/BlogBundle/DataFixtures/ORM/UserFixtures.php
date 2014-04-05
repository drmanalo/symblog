<?php

namespace Drm\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Drm\BlogBundle\Entity\User;
use Drm\BlogBundle\Entity\Role;

class UserFixtures extends AbstractFixture implements OrderedFixtureInterface
{

	public function load(ObjectManager $manager)
	{
	    $role = new Role();
	    $role->setName('Administrator');
	    $role->setRole('ROLE_ADMIN');
	    
	    $manager->persist($role);
	    
	    $user = new User();
	    $user->setUsername('admin');
	    $user->setEmail('admin@test.com');
	    $user->setIsActive(false);
	    $user->setPassword('111111');
	    
	    $user->addRole($role);
	    $manager->persist($user);
	    
	    $manager->flush();
	}

	public function getOrder()
	{
		return 3;
	}
}