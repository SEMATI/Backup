<?php

namespace Zottel\CarloSohlBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller {
	/**
	 * @Route("/hello/{name}")
	 * @Template()
	 */
	public function indexAction($name) {
		//die ("hello ".$name);
		return array();
	}
		
}
