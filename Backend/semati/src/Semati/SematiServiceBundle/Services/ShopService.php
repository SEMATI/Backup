<?php
namespace Semati\SematiServiceBundle\Services;

use Application\Sonata\UserBundle\ApplicationSonataUserBundle;
use Application\Sonata\UserBundle\Entity\User;
use Symfony\Bundle\DoctrineBundle\Registry;

class ShopService {
	
	/**
	 * 
	 * @var Doctrine\ORM\EntityRepository
	 */
	private $repository;
	
	private $encFactory;
	
	public function __construct(Registry $doctrine, $encFactory) {
		$this->repository = $doctrine->getRepository('ApplicationSonataUserBundle:User');
		$this->encFactory = $encFactory;
	}
	
	
	private function validateUser($username, $password) {
				
		$user = $user = $this->repository->findOneBy(array('username' => $username));
		if (!$user) {
			return false;
		}
		
		$encoder = $this->encFactory->getEncoder($user);
		$pw = $encoder->encodePassword($password, $user->getSalt());
		
		if ($pw == $user->getPassword()) {
			return true;
		}
		
		return false;
	}
	

	public function getProducts($username, $password, $category = false) {
		if (! $this->validateUser($username, $password)) {
			return "Bad credentials";
		}
		else{
			$products = array();
			$product = array();
			
			$proxy = new \SoapClient('http://www.fightstuff24.de.vu/index.php/api/soap/?wsdl');
		    $sessionId = $proxy->login('apiUser', '123456');
		
		    $catNameSearch = "";
		    $assignedProducts;
		    // TODO: Database Categorie Mapping
		    switch($category){
		    	case "T-Shirts":
		    		$catNameSearch = "T-Shirts";
		    		break;
		    	case "Shorts":
	    			$catNameSearch = "Shorts";
	    			break;
    			case "Sweatshirts":
    				$catNameSearch = "Hoodies";
    				break;
    			case "Schuhe":
    				$catNameSearch = "Schuhe";
    				break;
    			case "Sonstiges":
    				$catNameSearch = "Zubehör";
    				break;
		    	default:
		    		break;
		    	
		    }
		    
		    if($catNameSearch != ""){
		    	$assignedProducts = $proxy->call($sessionId, 'category.assignedProducts', array($this->getCategorieID($catNameSearch), 1));
		    	$assignedProducts = $this->array_value_recursive("product_id", $assignedProducts);
		    	
		    	// TODO: Standardisation von Array...
		    	$assignedProductPics = array();
		    	foreach($assignedProducts as $assignedProduct){
		    		$assignedProductPics = $proxy->call($sessionId, 'product_media.list', $assignedProduct); //foreach pic: url
		    		array_push($product, $assignedProductPics);
		    		
		    		$assignedProduct = $proxy->call($sessionId, 'product.info', $assignedProduct); //description, price, name
		    		array_push($product, $assignedProduct);
		    		array_push($products, $product);
		    	}
		    }
			return $products;
		}
	}
	
	public function getProduct($username, $password, $ID) {
		if (! $this->validateUser($username, $password)) {
			return "Bad credentials";
		}
		else{
			$product = array();
			
			$proxy = new \SoapClient('http://www.fightstuff24.de.vu/index.php/api/soap/?wsdl');
			$sessionId = $proxy->login('apiUser', '123456');

			$assignedProductPics = $proxy->call($sessionId, 'product_media.list', $ID); //foreach pic: url
			array_push($product, $assignedProductPics);
			
			$assignedProduct = $proxy->call($sessionId, 'product.info', $ID); //description, price, name
			array_push($product, $assignedProduct);

			return $product;
		}
	}
	
	private function getCategorieID($catNameSearch) {
	
		$proxy = new \SoapClient('http://www.fightstuff24.de.vu/index.php/api/soap/?wsdl');
		$sessionId = $proxy->login('apiUser', '123456');
	
		$categories = $proxy->call($sessionId, 'category.tree');
		
		return $this->getChildrenCats($categories, $catNameSearch);
	}
	
	private function getChildrenCats(array $categories, $catNameSearch){
		
		if(isset($categories['name']) && $categories['name'] == $catNameSearch){
			return $categories['category_id'];
		}
		else if(isset($categories['children'])){
			$checker = "";
			foreach($categories['children'] as $child){
				
				$checker = $this->getChildrenCats($child, $catNameSearch);
				if($checker != ""){
					return $checker;
				}
			}
		}
	}
	
	public function getCategories($username, $password) {
		
		// TODO: Database Categorie Mapping
		
		//$sematiCats = array("Shirts")
		if (! $this->validateUser($username, $password)) {
			return "Bad credentials";
		}
		else{
			$proxy = new \SoapClient('http://www.fightstuff24.de.vu/index.php/api/soap/?wsdl');
		    $sessionId = $proxy->login('apiUser', '123456');
		
		     
		    $categories = $proxy->call($sessionId, 'category.tree');
		    
		    return $categories;//$this->array_value_recursive('name', $categories);
		}
	}
	
	private function array_value_recursive($key, array $arr){
		$val = array();
		array_walk_recursive($arr, function($v, $k) use($key, &$val){
			if($k == $key) array_push($val, $v);
		});
		return count($val) > 1 ? $val : array_pop($val);
	}
	
}