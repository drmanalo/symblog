<?php

namespace Drm\BlogBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
	public function indexAction()
	{
		return $this->render('DrmBlogBundle:Page:index.html.twig');
	}

	public function aboutAction()
	{
		return $this->render('DrmBlogBundle:Page:about.html.twig');
	}
}
