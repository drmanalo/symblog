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
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function navigationAction() 
	{
		return $this->render('DrmBlogBundle:Page:navigation.html.twig');
	}
	
	/**
	 * display footer
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function footerAction() 
	{
		return $this->render('DrmBlogBundle:Page:footer.html.twig');
	}
	
	/**
	 * display the index
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();
		
		$blogs = $em->getRepository('DrmBlogBundle:Blog')->getLatestBlogs();
	
		return $this->render('DrmBlogBundle:Page:index.html.twig', 
				array('blogs' => $blogs)
		);
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
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function contactAction()
	{
		$enquiry = new Enquiry();
		$form = $this->createForm(new EnquiryType(), $enquiry);

		$request = $this->getRequest();
		
		if ($request->getMethod() == 'POST') {
			
			$form->bind($request);

			if ($form->isValid()) {

				$message = \Swift_Message::newInstance()
						->setSubject('Contact enquiry from symblog')
						->setFrom('enquiries@symblog.co.uk')
						->setTo($this->container->getParameter('drm_blog.emails.contact_email'))
						->setBody($this->renderView('DrmBlogBundle:Page:contactEmail.txt.twig',
												array('enquiry' => $enquiry)));
				$this->get('mailer')->send($message);
				
				$this->get('session')->getFlashBag()->set('blogger-notice',
						'Your contact enquiry was successfully sent. Thank you!');
				

				// Redirect - This is important to prevent users re-posting
				// the form if they refresh the page
				return $this->redirect($this->generateUrl('DrmBlogBundle_contact'));
			}

		}

		return $this->render('DrmBlogBundle:Page:contact.html.twig',
						array('form' => $form->createView()));
	}
}
