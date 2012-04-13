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
	
	
	public function test($username, $password) {
				
		$user = $this->findUser($username);
		$encoder = $this->encFactory->getEncoder($user);
		$pw = $encoder->encodePassword($password, $user->getSalt());
		
		if ($pw == $user->getPassword()) {
			return "valid";
		}
		
		return "fuck";
	}
	
	/**
	 * 
	 * @param unknown_type $username
	 * @return User
	 */
	private function findUser($username) {
		$user = $this->repository->findOneBy(array('username' => $username));
		if (!$user) {
			die("no such user");
		}
		return $user;
	}
	
}