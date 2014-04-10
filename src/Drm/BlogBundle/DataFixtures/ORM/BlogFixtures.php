<?php

namespace Drm\BlogBundle\DataFixtures\ORM;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Drm\BlogBundle\Entity\Blog;
use Drm\BlogBundle\Entity\Comment;

class BlogFixtures implements FixtureInterface
{

	public function load(ObjectManager $manager)
	{

	    $blog = new Blog();
		
		$blog->setTitle('Test Title');
        $blog->setBlog('Test Content');
		$blog->setAuthor('linus');
		$blog->setTags('linux');
		$blog->setCreated(new \DateTime("2012-07-23 21:21:46"));
		$blog->setUpdated($blog->getCreated());

		$manager->persist($blog);
		
		$comment = new Comment();
		 
		$comment->setUser('symfony');
		$comment->setComment('Test comment');
		$comment->setBlog($manager->merge($blog));
		$comment->setCreated(new \DateTime("2012-07-23 22:22:46"));
		 
		$manager->persist($comment);
		 
		$manager->flush();
    }

}
