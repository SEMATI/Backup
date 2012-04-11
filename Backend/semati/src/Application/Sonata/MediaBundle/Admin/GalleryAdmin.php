<?php
namespace Application\Sonata\MediaBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;

use Sonata\MediaBundle\Admin\GalleryAdmin as BaseGalleryAdmin;


class GalleryAdmin extends BaseGalleryAdmin {
	
	protected function configureFormFields(FormMapper $formMapper) {
		parent::configureFormFields($formMapper);
		
		$formMapper->add('description', 'textarea');
		$formMapper->add('urlSlug', 'text');
		$formMapper->add('previewImage', 'sonata_type_model', array(), array('edit' => 'list')); // , 'link_parameters' => array('context' => 'components')
		$formMapper->add('internal', 'checkbox', array('required' => false));
	}

}
