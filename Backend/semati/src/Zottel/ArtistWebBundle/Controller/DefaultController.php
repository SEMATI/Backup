<?php

namespace Zottel\ArtistWebBundle\Controller;
use Application\Sonata\MediaBundle\Entity\Media;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller {
	
	/**
	 * @Route(name="aw.gallery_show", pattern="gallery/{slug}")
	 * @Template
	 */ 
	public function showGalleryAction($slug) {

		$mgr = $this->get('sonata.media.manager.gallery');
		
		
		$gal = $mgr->findOneBy(array('id' => 1));
		
		return array('gallery' => $gal);
	}
	
}
