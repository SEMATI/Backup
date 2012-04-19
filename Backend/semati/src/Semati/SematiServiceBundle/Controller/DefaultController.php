<?php

namespace Semati\SematiServiceBundle\Controller;


use Symfony\Component\HttpFoundation\Response;

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

		//$test = $shop->getCategories("admin", "password");
		
		//echo(print_r($test));
		
		$assignedProducts = $shop->getProducts("admin", "password", "T-Shirts");
		echo "<pre>";
		var_dump($assignedProducts); // Will output assigned products.
		echo "</pre>";
		//$client = new \soapclient('http://localhost/app_dev.php/soap?wsdl');
		
		
		
		//$result = $client->__call('getProducts', array('username' => 'admin', 'password' => 'password'));
		
		die (" ...");
		
	}
	
	/**
	 * @Route("/soap")
	 * @Template()
	 */
	public function serviceAction() {
	
		$server = new \SoapServer("http://localhost/ShopServicewsdl.wsdl");
		$server->setObject($this->get('shop_service'));
		
		$response = new Response();
		$response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');
		
		ob_start();
		$server->handle();
		$response->setContent(ob_get_clean());
		ob_clean();
		//die('service');
		// TODO: add SOAP server service code from tutorial
	
		return $response;
	}

}
