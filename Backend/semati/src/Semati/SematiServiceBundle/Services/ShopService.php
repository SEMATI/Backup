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
		
		
	}
	
}