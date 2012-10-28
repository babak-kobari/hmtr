<?php

/**
 * Poi ProfileController
 * 
 * @author Babak
 * @version  1
 */

class Poi_ProfileController extends Core_Controller_Action
{
	/**
	 * The default action - show the home page
	 */
	protected $_poimodel;
	

	public function init() 
	{
        $this->view->leftbar1title='Points of Interest';
        $this->view->leftbar1menuname='poileftmenu1';
        $this->_poimodel = new Poi_Model_Poi_Manager();
      
        
	}

	public function indexAction() 
	{
	    $criteria = array ();
	    $pois = $this->_poimodel->getPoiList ( $criteria, $this->getRequest ()->getParam ( 'page', 1 ), false );
	    $this->view->assign ( array (
	            'pois' => $pois));
	             
	}
	
	public function addstayAction()
	{
	    $Stay=$this->_setParam('poi_type', 'Stay');
	     $this->_forward('generalinfo');
	}
	public function addeatAction()
	{
	    $Stay=$this->_setParam('poi_type', 'Eat');
	    $this->_forward('generalinfo');
	}
	public function addthingsAction()
	{
	    $Stay=$this->_setParam('poi_type', 'Things');
	    $this->_forward('generalinfo');
	}
	
	public function generalinfoAction() 
	{
	    $poi_id=$this->_getParam('id');
	    $poi_type=$this->_getParam('poi_type');
	    $params=array('Amenities'=>array(),
	                  'Dining_Options'=>array(),
	                  'Cuisine'=>array());
	    $images=array();
	    if (!is_null($poi_id))
	    {
	        $row = $this->_poimodel->getPoibyId ( $poi_id );
	        $poi_type=$row['poi_type'];
	        $images=$row->getImages()->toarray();
	        if ($poi_type=='Stay')
	        {
    	        $params['Amenities']=$row->getFacl('Amenities')->toarray();
	        }
	    	if ($poi_type=='Eat')
	        {
    	        $params['Dining_Options']=$row->getFacl('Dining_Options')->toarray();
	            $params['Cuisine']=$row->getFacl('Cuisine')->toarray();
	        }
	    }
	    $facl_value = array();
	    foreach ($params as $key => $value)
	    {
	        $facl_temp = array();
	        foreach ($value as $key2 => $value2)
	        {
	            $facl_temp=array_merge($facl_temp,explode(' ',$value2['poifcl_param_id']));
	        }
	        $facl_value[$key]=$facl_temp;
	    }

	    
	    $form = new Poi_Form_Poi_Generalinfo(array('poi_id'=>$poi_id,'poi_type'=>$poi_type));
	     
	    if (isset($row ))
	        $this->view->form= $form->populate($row->toarray());
	    else
	    {
            $this->view->form = $form;
	    }
	    if ($poi_type=='Stay' and isset($facl_value['Amenities']))
    	    $form->_setfaclvalue ($facl_value['Amenities'],'poi_amenities');
	    if ($poi_type=='Eat' and isset($facl_value['Dining_Options']))
	        $form->_setfaclvalue ($facl_value['Dining_Options'],'poi_dining_options');
	    if ($poi_type=='Eat' and isset($facl_value['Cuisine']))
    	    $form->_setfaclvalue ($facl_value['Cuisine'],'Cuisine');
	     
	    
	     
	    $this->view->headScript()->
	        appendFile('https://maps.googleapis.com/maps/api/js?sensor=false&libraries=places');
	    $this->view->headScript()->appendFile('http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js');
	    $this->view->headScript()->appendFile('/js/googlemap.js');
	    $this->view->headScript()->appendFile('/js/jquery-1.8.2.js');
	    $this->view->headScript()->appendFile('/js/jquery-ui.js');
	    $this->view->headScript()->appendFile('/js/coin-slider.min.js');
	    $this->view->headLink()->appendStylesheet('/css/default/coin-slider-styles.css');
	    $this->view->headLink()->appendStylesheet('/css/default/jquery-ui.css');
	     
	    $this->view->title = 'Point Of Interest';
	    $this->view->poi_id = $poi_id;
	    $this->view->poi_type=$poi_type;
	    $this->view->images=$images;

	    
	    
	    if ($this->_request->isPost()
	            && $form->isValid($this->_getAllParams()))
	    {
	    
	        $info= $this->_getAllParams();
//	        $row->setFromArray($form->getValues());
//	        $faclrow=new Poi_Model_poifacl_Table();
//	        $faclrow->savefaclrows ( $info ['poi_amenities'], $poi_id,$a );
		    $request = $this->getRequest ();
	        $row=$request->getPost (); 
	        $poi_id=$this->_poimodel->savePoi($form, $row,$poi_id,$poi_type,$params,$images);
	        $this->_helper->flashMessenger('Profile Updated');
	        $row = $this->_poimodel->getPoibyId ( $poi_id );
	    	if ($poi_type=='Stay')
    	        $form->_setfaclvalue ($info ['poi_amenities'],'poi_amenities');
	        if ($poi_type=='Eat')
	        {
	            $form->_setfaclvalue ($info ['poi_dining_options'],'poi_dining_options');
	            $form->_setfaclvalue ($info ['Cuisine'],'Cuisine');
	        }
	        $a=$row->getImages()->toarray();
	        $this->view->images=$a;
	        $this->_helper->redirector('index');
	        $this->render('generalinfo');
	         
	    
	    }
	     
	}

	public function amenitiesAction() 
	{
	    unset($poimodel);
	    unset($row);
	    unset($form);
	    unset($a);
	    unset($this->view->form);
	    $poi_id=$this->_getParam('id');
	    $poimodel = new Poi_Model_Poi_Table();
	    $row = $poimodel ->getPoibyId ( $poi_id );
	    $form = new Poi_Form_Poi_Amenities(array('poi_id'=>$poi_id));
	    if (isset($row ))
	        $this->view->form= $form->populate($row->toarray());
	    else
	    $this->view->form = $form;
	    $a=$row->getFacl()->toarray();
	    $facl_value = array();
	     
	    $this->view->title = 'amenities';

	    foreach ($a as $key => $value)
	    {
	        $facl_value=array_merge($facl_value,explode(' ',$value['poifcl_param_id']));
	    }
	    
	    $form->_setfaclvalue ($facl_value);
	    $this->view->poi_id = $poi_id;
	    if ($this->_request->isPost())
	    {
	        $info= $this->_getAllParams();
	         
//	        $info= $form->getValues();
	        $faclrow=new Poi_Model_poifacl_Table();
	        $faclrow->savefaclrows ( $info ['poi_amenities'], $poi_id,$a );
	         
	        $this->_helper->flashMessenger('Profile Updated');
    	    $form->_setfaclvalue ($info ['poi_amenities']);
	        $this->render('amenities');
	    }
	    
	     
	}
	public function relatedAction() 
	{
	}
	public function imagesAction() 
	{
	    unset($poimodel);
	    unset($row);
	    unset($form);
	    unset($a);
	    unset($this->view->form);
	    $poi_id=$this->_getParam('id');
	    $poimodel = new Poi_Model_Poi_Table();
	    $row = $poimodel ->getPoibyId ( $poi_id );
	    $form = new Poi_Form_Poi_images(array('poi_id'=>$poi_id));
	    if (isset($row ))
	        $this->view->form= $form->populate($row->toarray());
	    else
	    $this->view->form = $form;
	    $a=$row->getImages()->toarray();
	    $this->view->images=$a;
	     
	    
	    $this->view->title = 'Images';
	    
	    $this->view->poi_id = $poi_id;

	    $this->view->headLink()->appendStylesheet('/css/default/slideshow.css');
	    $this->view->headScript()->appendFile('http://cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js');
	     
	    
	    if ($this->_request->isPost())
	    {
	        $form->getElement ( 'poi_images' )->receive ();
	        $info=$form->getElement ( 'poi_images' )->getValue();
	        
	         
	        //	        $info= $form->getValues();
	        $imagerow=new Poi_Model_poiimages_Table();
	        $imagerow->saveimagesrows( $info, $poi_id);
	    
	        $this->_helper->flashMessenger('Profile Updated');
	        unset($this->view->images);
	        $a=$row->getImages()->toarray();
	        $this->view->images=$a;
	        $this->render('images');
//	        $this->_helper->redirector('images');
	    }
	     
	}
}
