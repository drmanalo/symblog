<?php

namespace Drm\BlogBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Blog controller
 *
 */
class BlogController extends Controller
{

	/**
	 * display blog by id
	 * @param unknown $id
	 */
	public function showAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		
		$blog = $em->getRepository('DrmBlogBundle:Blog')->find($id);
		
		if (!$blog) {
			throw $this->createNotFoundException('Unable to find blog post');
		}
		
		return $this->render('DrmBlogBundle:Blog:show.html.twig' , array('blog' => $blog));
	}
	
}
