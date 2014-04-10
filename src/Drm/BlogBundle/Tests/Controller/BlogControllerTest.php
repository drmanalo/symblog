<?php

namespace Drm\BlogBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class BlogControllerTest extends WebTestCase
{
    
    private $client;
    
    public function setUp() {
        
        $classes = array(
                // classes should implement Doctrine\Common\DataFixtures\FixtureInterface
                'Drm\BlogBundle\DataFixtures\ORM\UserFixtures',
                'Drm\BlogBundle\DataFixtures\ORM\BlogFixtures'
        );
        
        $this->loadFixtures($classes);
        
        $this->client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW'   => '12341234',
        ));
        
    }
    
    public function testCompleteScenario()
    {
        $crawler = $this->client->request('GET', '/blog/');
        
        // assert that user has been authenticated
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        
        // create new blog
        $link = $this->client->click($crawler->selectLink('Create New Blog')->link());
        
        // fill up required fields
        $form = $link->selectButton('Create')->form(array(
                'drm_blogbundle_blog[title]' => 'Test',
                'drm_blogbundle_blog[author]' => 'lekat',
                'drm_blogbundle_blog[tags]' => 'test',
                'drm_blogbundle_blog[blog]' => 'sample content',
        ));
        
        $this->client->submit($form);
        $redirect = $this->client->followRedirect();
        
        $this->assertEquals(1, $redirect->filter('h2:contains("Test")')->count());

        // edit the blog
        $link = $this->client->click($crawler->selectLink('edit/delete')->link());

        $form = $link->selectButton('Update')->form(array(
            'drm_blogbundle_blog[title]' => 'Edited',
        ));

        $this->client->submit($form);
        $redirect = $this->client->followRedirect();

        $this->assertEquals(1, $redirect->filter('[value="Edited"]')->count());

        // delete the blog
        $this->client->submit($link->selectButton('Delete')->form());
        $redirect = $this->client->followRedirect();

        $this->assertNotRegExp('/Edited/', $this->client->getResponse()->getContent());
        
    }

}