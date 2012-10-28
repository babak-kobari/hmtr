<?php

/**
 * PoiController
 * 
 * @author Babal
 * @version  1
 */

require_once 'Zend/Controller/Action.php';
class Poi_PoiController extends Core_Controller_Action
{
	/**
	 * The default action - show the home page
	 */
	protected $_poimodel;

	public function init() {
		$this->_poimodel = new Exp_Model_Poi ();
		$form = $this->getPoiRegisterForm ();
		// $form = new Exp_Form_Poi_Register();
		$form->setModel ( $this->_poimodel );
		$form->filldata ();
		$this->view->poiRegisterForm = $form;
		$this->view->model = $this->_poimodel;
	}
	public function indexAction() {
		$criteria = array ();
		$pois = $this->_poimodel->getPoiList ( $criteria, $this->getRequest ()->getParam ( 'page', 1 ), false );
		$this->view->assign ( array (
				'pois' => $pois 
		) );
	}
	public function viewAction() {
		$poi_id = $this->getRequest ()->getParam ( 'poi_id', 0 );
		$poi = $this->_poimodel->getPoibyId ( $poi_id );
		$this->view->assign ( array (
				'poi' => $poi 
		) );
	}
	public function editAction() {
		$poi_id = $this->getRequest ()->getParam ( 'poi_id', 0 );
		$poi = $this->_poimodel->getPoibyId ( $poi_id );
		$form = $this->getPoiRegisterForm ();
		$this->view->poiRegisterForm = $form->populate ( $poi->toarray () );
		$a=$poi->Facl->toarray();
		$facl_value = array();
		foreach ($a as $key => $value)
		{
			$facl_value=array_merge($facl_value,explode(' ',$value['poifcl_param_id']));
		}

		$form->_setfaclvalue ($facl_value);
		
		$this->render ( 'Register' );
	}
	public function registerAction() {
	}
	public function saveAction() {
		$request = $this->getRequest ();
		if (! $request->isPost ()) {
			return $this->_helper->redirector ( 'register' );
		}
		$id = $this->_poimodel->savePoi ( $request->getPost () );
		return $this->_helper->redirector ( 'register' );
	}
	public function getPoiRegisterForm() {
		$urlHelper = $this->_helper->getHelper ( 'url' );
		$this->_forms ['poiRegister'] = $this->_poimodel->getForm ( 'poiRegister' );
		$this->_forms ['poiRegister']->setAction ( $urlHelper->url ( array (
				'controller' => 'Poi',
				'action' => 'save' 
		), 'default' ) );
		$this->_forms ['poiRegister']->setMethod ( 'post' );
		return $this->_forms ['poiRegister'];
	}
}
