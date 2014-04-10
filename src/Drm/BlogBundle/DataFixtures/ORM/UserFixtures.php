<?php

namespace Drm\BlogBundle\DataFixtures\ORM;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Drm\BlogBundle\Entity\User;
use Drm\BlogBundle\Entity\Role;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class UserFixtures implements FixtureInterface 
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
        $user->setPassword('12341234');
         
        $user->addRole($role);
        
        $manager->persist($user);
        $manager->flush();
    }
}
