<?php

namespace Zottel\ArtistWebBundle\Controller;

use Sonata\MediaBundle\Entity\GalleryManager;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ComponentsController extends Controller {

	/**
	 * @Template
	 */
	public function galleryNavigationAction($format, $context = false) {
		$mgr = $this->get('sonata.media.manager.gallery');
		
		$c = array('enabled' => true);
		$c = array('internal' => false);
		if ($context) {
			$c['context'] = $context;
		} 
		
		$galleries = $mgr->findBy($c);
		
		return array('galleries' => $galleries, 'format' => $format);
	}
	
	/**
	 * @Template
	 */
	public function galleryLinkAction($urlSlug, $format = false) {
		$mgr = $this->get('sonata.media.manager.gallery');
		
		$gallery = $mgr->findOneBy(array('urlSlug' => $urlSlug));
		
		return array('gallery' => $gallery, 'format' => $format);
	}
	
			
}
