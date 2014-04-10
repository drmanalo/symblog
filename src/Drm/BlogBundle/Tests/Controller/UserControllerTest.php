<?php

namespace Drm\BlogBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
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
        $crawler = $this->client->request('GET', '/user/');
        
        // assert client authentication happened
        // 302 means redirected to login page
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        // create a user
        $button= $this->client->click($crawler->selectLink('Add User')->link());

        // Fill in the form and submit it
        $form = $button->selectButton('Create')->form(array(
            'drm_blogbundle_user[username]'  => 'Hedrig',
            'drm_blogbundle_user[password]'  => 'Eamon',
            'drm_blogbundle_user[email]'  => 'noemail@nominet.net',
            'drm_blogbundle_user[isActive]'  => 1
        ));

        $this->client->submit($form);
        $redirect = $this->client->followRedirect();

        $this->assertEquals(1, $redirect->filter('td:contains("Hedrig")')->count());

        // edit the user
        $button = $this->client->click($crawler->selectLink('edit/delete')->link());

        $form = $button->selectButton('Update')->form(array(
            'drm_blogbundle_user[username]'  => 'Edited'
        ));

        $this->client->submit($form);
        $redirect = $this->client->followRedirect();

        $this->assertEquals(``, $crawler->filter('[value="Edited"]')->count());

        //$this->client->submit($link->selectButton('Delete')->form());
        $this->client->submit($button->selectButton('Delete')->form());
        $redirect = $this->client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/Edited/', $this->client->getResponse()->getContent());
    }

}
