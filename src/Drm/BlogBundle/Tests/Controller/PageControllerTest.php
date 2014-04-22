<?php

namespace Drm\BlogBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{

	public function testIndex()
	{
		$client = static::createClient ();
		$crawler = $client->request ( 'GET', '/blogs/all/1' );
		
		$this->assertTrue ( $crawler->filter ( 'article.blog' )
			->count () > 0 );
		
	}

	public function testAbout()
	{
		$client = static::createClient ();
		$crawler = $client->request ( 'GET', '/about' );
		
		$expected = $crawler->filter ( 'h2:contains("About This Site")' )
			->count ();
		
		$this->assertEquals ( 1, $expected );
	}

	public function testContact_MethodGet()
	{
		$client = static::createClient ();
		$crawler = $client->request ( 'GET', '/contact' );
		
		$expected = $crawler->filter ( 'h2:contains("Contact Me")' )
			->count ();
		
		$this->assertEquals ( 1, $expected );
	}

	public function testContact_MethodPost()
	{
		$client = static::createClient ();
		$crawler = $client->request ( 'POST', '/contact' );
		
		$form = $crawler->selectButton ( 'Contact Me' )
			->form ();
		
		$form ['contact[name]'] = 'name';
		$form ['contact[email]'] = 'email@email.com';
		$form ['contact[subject]'] = 'Subject';
		$form ['contact[body]'] = 'The comment body must be at least 50 characters long as there is a validation constraint on the Enquiry entity';
		
		// submit the form
		$client->submit ( $form );
		
		// follow redirection
		$redirect = $client->followRedirect ();
		
		$expected = $redirect->filter ( '.alert-info:contains("Your contact enquiry was successfully sent. Thank you!")' )
			->count ();
		
		$this->assertEquals ( 1, $expected );
	}
}
