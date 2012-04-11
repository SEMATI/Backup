<?php
namespace Zottel\ArtistWebBundle\Twig\Extension;
use Symfony\Bundle\FrameworkBundle\Templating\Helper\ActionsHelper;

class ArtistWebTwigExtension extends \Twig_Extension {

	protected static $CONTROLLER_NAME = 'ZottelArtistWebBundle:Components';

	protected $enviornment;
	protected $actionsHelper;
	
	public function __construct(ActionsHelper $actionsHelper) {
		$this->actionsHelper = $actionsHelper;
	}
	
	/**
	 * @param Twig_Environment $environment
	 */
	public function initRuntime(\Twig_Environment $environment) {
		$this->enviornment = $environment;
	}
	
	
	/**
	 * @return multitype:
	 */
	public function getFunctions() {
		// TODO: Auto-generated method stub
		return array(
				'aw_gallery_nav' => new \Twig_Function_Method($this, 'renderGalleryNavigation', array('is_safe' => array('html'))),
				'aw_gallery_link' => new \Twig_Function_Method($this, 'renderGalleryLink', array('is_safe' => array('html'))));
	}


	/**
	 * @return array
	 */
// 	public function getTokenParsers() {
// 		return array();
// 	}

	/**
	 * Returns the name of the extension.
	 *
	 * @return string The extension name
	 */
	public function getName() {
		return 'zottel_artist_web';
	}
	
	private function callComponentsController($actionName, $arguments) {
		return $this->actionsHelper->render(self::$CONTROLLER_NAME.':'.$actionName, $arguments);
	} 

	/**
	 * delegate to ComponentsController
	 * @param string $context
	 */
	public function renderGalleryNavigation($format = false, $context = false) {
		$res = $this->callComponentsController('galleryNavigation', 
				array('context' => $context, 'format' => $format));
		return $res;
	}
	
	/**
	 * delegate to ComponentsController
	 * @param string $urlSlug
	 */
	public function renderGalleryLink($urlSlug, $format = false) {
		return $this->callComponentsController('galleryLink', 
				array('urlSlug' => $urlSlug, 'format' => $format));
	}

}
