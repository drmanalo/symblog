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
			throw $this->createNotFoundException('Unable to find Blog post.');
		}
		
		$comments = $em->getRepository('DrmBlogBundle:Comment')
						->getCommentsForBlog($blog->getId());
		
		return $this->render('DrmBlogBundle:Blog:show.html.twig', array(
				'blog'      => $blog,
				'comments'  => $comments
		));
		
	}
	
}