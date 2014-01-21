<?php

namespace Drm\BlogBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase
{

	public function testShowAction_NotFound()
	{
		$client = static::createClient ();
		$client->request ( 'GET', '/a-day-with-symfony' );
		
		$this->assertEquals ( 404, $client->getResponse ()
			->getStatusCode () );
	}

	public function testShowAction_Exists()
	{
		$client = static::createClient ();
		$client->request ( 'GET', '/1/a-day-with-symfony2' );
		
		$crawler = $client->getCrawler ();
		$expected = $crawler->filter ( 'h2:contains("A day with Symfony2")' )
			->count ();
		
		$this->assertEquals ( 1, $expected );
	}
}
