<?php
namespace Drm\BlogBundle\Tests\Controller;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class CommentControllerTest extends WebTestCase
{

    private $client;

    public function setUp ()
    {
        $classes = array(
                // classes should implement
                // Doctrine\Common\DataFixtures\FixtureInterface
                'Drm\BlogBundle\DataFixtures\ORM\UserFixtures',
                'Drm\BlogBundle\DataFixtures\ORM\BlogFixtures'
        );
        
        $this->loadFixtures($classes);
        
        $this->client = static::createClient(array(), 
                array(
                        'PHP_AUTH_USER' => 'admin',
                        'PHP_AUTH_PW' => '12341234'
                ));
    }

    public function testAddComment ()
    {
        $crawler = $this->client->request('POST', '/comment/1');
        
        $form = $crawler->selectButton('Submit')->form();
        
        $crawler = $this->client->submit($form, 
                array(
                        'drm_blogbundle_comment[user]' => 'name',
                        'drm_blogbundle_comment[comment]' => 'comment'
                ));
        
        $redirect = $this->client->followRedirect();
        
        // Check comment is now displaying on page, as the last entry
        $articleCrawler = $redirect->filter(
                'section .previous-comments article')->last();
        
        $this->assertEquals('name', 
                $articleCrawler->filter('header span.highlight')
                    ->text());
        $this->assertEquals('comment', 
                $articleCrawler->filter('p')
                    ->last()
                    ->text());
    }
}