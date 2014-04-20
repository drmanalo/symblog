<?php
namespace Drm\BlogBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class UrlAccessTest extends WebTestCase
{
    public function testAccessDeniedForUnathorizedUsers()
    {
        $this->_testReturnCode(405, $this->getUrl('blog_create', array()));
        $this->_testReturnCode(302, $this->getUrl('blog_edit', array('id' => 0)));
        $this->_testReturnCode(405, $this->getUrl('blog_update', array('id' => 0)));
        $this->_testReturnCode(302, $this->getUrl('blog_delete', array('id' => 0)));
        
        $this->_testReturnCode(405, $this->getUrl('user_create', array()));
        $this->_testReturnCode(302, $this->getUrl('user_edit', array('id' => 0)));
        $this->_testReturnCode(405, $this->getUrl('user_update', array('id' => 0)));
        $this->_testReturnCode(405, $this->getUrl('user_delete', array('id' => 0)));
        
    }
    
    public function testAccessAllowedForUnathorizedUsers()
    {
        $this->loadFixtures(array('Drm\BlogBundle\DataFixtures\ORM\BlogFixtures'));
        // homepage is a redirect
        $this->_testReturnCode(302, $this->getUrl('DrmBlogBundle_homepage'));
        $this->_testReturnCode(200, $this->getUrl('DrmBlogBundle_blogs'));
        $this->_testReturnCode(200, $this->getUrl('DrmBlogBundle_contact'));
        $this->_testReturnCode(200, $this->getUrl('DrmBlogBundle_about'));
        $this->_testReturnCode(200, $this->getUrl('DrmBlogBundle_blog_show', 
                array('id' => 1, 'slug' => 'test-title')));
    }
    
    /**
    * Check return code
    *
    * @param int $code Expected code
    * @param string $url Page url for test
    * @param bool $authentication Log in
    *
    * @return void
    */
    protected function _testReturnCode($code, $url, $authentication = false)
    {
        $client = $this->makeClient($authentication);
        $crawler = $client->request('GET', $url);

        $this->assertEquals($code, $client->getResponse()->getStatusCode());
    }
    
}