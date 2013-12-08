<?php

namespace Drm\BlogBundle\Tests;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
	public function testIndex()
	{
		$client = static::createClient();

		$crawler = $client->request('GET', '/');

		$expected = $crawler->filter('html:contains("Blog homepage")')->count();

		$this->assertEquals(1, $expected);
	}

	public function testAbout()
	{
		$client = static::createClient();

		$crawler = $client->request('GET', '/about');

		$expected = $crawler->filter('h2:contains("About This Site")')->count();

		$this->assertEquals(1, $expected);
	}
}
