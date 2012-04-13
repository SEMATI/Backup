<?php

namespace Semati\SematiServiceBundle\Controller;
use Semati\SematiServiceBundle\Services\ShopService;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller {
	/**
	 * @Route("/")
	 * @Template()
	 */
	public function indexAction() {
		$shop = $this->get('shop_service');

		echo($shop->test('admin', 'password'));
		
		die (" yeah");
	}
	
	/**
	 * @Route("/service")
	 * @Template()
	 */
	public function serviceAction() {
	
		die('service');
		// TODO: add SOAP server service code from tutorial
	
	}

}
