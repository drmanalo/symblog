<?php

namespace Drm\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Drm\BlogBundle\Entity\Enquiry;
use Drm\BlogBundle\Form\EnquiryType;

/**
 * Page controller
 */
class PageController extends Controller
{

	/**
	 * display navigation
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function navigationAction()
	{
		return $this->render ( 'DrmBlogBundle:Page:navigation.html.twig' );
	}

	/**
	 * display footer
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function footerAction()
	{
		return $this->render ( 'DrmBlogBundle:Page:footer.html.twig' );
	}

	public function indexAction() {
	    
	   return $this->redirect(
	           $this->generateUrl('DrmBlogBundle_blogs', array('tag' => 'all', 'page' => 1)
	   ));   
	}
	
	
	/**
	 * display the index
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function blogsAction($tag, $page)
	{
		$em = $this->getDoctrine()->getManager();
		
		$total_posts = $em->getRepository('DrmBlogBundle:Blog')
		                      ->getTotalNumberOfBlogs($tag);
		
		$posts_per_page = $this->container
		                  ->getParameter('drm_blog.max_posts_on_homepage');

		$last_page = ceil($total_posts / $posts_per_page);
		$previous_page = $page > 1 ? $page - 1 : 1;
		$next_page = $page < $last_page ? $page + 1 : $last_page;
		
		$blogs = $em->getRepository('DrmBlogBundle:Blog')
		      ->getLatestBlogs($tag, $posts_per_page, ($page - 1) * $posts_per_page);
		
		return $this->render ('DrmBlogBundle:Page:index.html.twig', array (
				'blogs' => $blogs,
		        'last_page' => $last_page,
		        'previous_page' => $previous_page,
		        'current_page' => $page,
		        'next_page' => $next_page,
		        'total_posts' => $total_posts
		));
	}

	/**
	 * display about page
	 */
	public function aboutAction()
	{
		return $this->render('DrmBlogBundle:Page:about.html.twig');
	}

	/**
	 * display contact page
	 *
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function contactAction()
	{
		$enquiry = new Enquiry();
		$form = $this->createForm(new EnquiryType(), $enquiry);
		
		$request = $this->getRequest();
		
		if ($request->getMethod() == 'POST') {
			
			$form->bind ($request);
			
			if ($form->isValid()) {
				
				$message = \Swift_Message::newInstance ()->setSubject ( 'Contact enquiry from symblog' )
					->setFrom ( 'enquiries@symblog.co.uk' )
					->setTo ( $this->container->getParameter ( 'drm_blog.emails.contact_email' ) )
					->setBody ( $this->renderView ( 'DrmBlogBundle:Page:contactEmail.txt.twig', array (
						'enquiry' => $enquiry 
				) ) );
				$this->get ( 'mailer' )
					->send ( $message );
				
				$this->get ( 'session' )
					->getFlashBag ()
					->set ( 'blogger-notice', 'Your contact enquiry was successfully sent. Thank you!' );
				
				// Redirect - This is important to prevent users re-posting
				// the form if they refresh the page
				return $this->redirect ( $this->generateUrl ( 'DrmBlogBundle_contact' ) );
			}
		}
		
		return $this->render ( 'DrmBlogBundle:Page:contact.html.twig', array (
				'contact_form' => $form->createView () 
		) );
	}

	/**
	 * Display the tag cloud
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function sidebarAction()
	{
		$em = $this->getDoctrine ()
			->getManager ();
		
		$tags = $em->getRepository ( 'DrmBlogBundle:Blog' )
			->getTags ();
		
		$tagWeights = $em->getRepository ( 'DrmBlogBundle:Blog' )
			->getTagWeights ( $tags );
		
		$commentLimit = $this->container->getParameter ( 'drm_blog.comments.latest_comment_limit' );
		
		$latestComments = $em->getRepository ( 'DrmBlogBundle:Comment' )
			->getLatestComments ( $commentLimit );
		
		return $this->render ( 'DrmBlogBundle:Page:sidebar.html.twig', array (
				'latestComments' => $latestComments,
				'tags' => $tagWeights 
		) );
	}
}
