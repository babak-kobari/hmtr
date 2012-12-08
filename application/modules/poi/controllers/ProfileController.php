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
	    $Eat=$this->_setParam('poi_type', 'Eat');
	    $this->_forward('generalinfo');
	}
	public function addthingsAction()
	{
	    $Things=$this->_setParam('poi_type', 'Things');
	    $this->_forward('generalinfo');
	}
	
	
	
	
	public function thngsparamAction()
	{
	    $poi_id=$this->_getParam('id');
	    $thingsparam=$this->_getParam('param_id');
	    $paramtable= new Users_Model_Param_Table();
	    $thingsparam=$paramtable->getparambyId($thingsparam);
	    $params=array(
	            'Things_options'=>array(),
	            'Things_activity'=>array());
	    if (!$poi_id=='undefined')
	    {
	        $row = $this->_poimodel->getPoibyId ( $poi_id );
	        $params['Things_options']=$row->getFacl($thingsparam->param_category_id)->toarray();
	        $params['Things_activity']=$row->getFacl($thingsparam->param_category_id.'__Act')->toarray();
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
	    
	     
	    $form = new Poi_Form_Poi_Things(array('param_desc_id' => $thingsparam->param_category_desc));
	    $this->view->form = $form;
	    $form->_setfaclvalue ($facl_value['Things_options'],'poi_things_options');
        $form->_setfaclvalue ($facl_value['Things_activity'],'poi_things_activity');
	    $this->_helper->layout->disableLayout();
	    $this->render('poithingsparams');
        	}

	
	public function generalinfoAction() 
	{
	    $poi_id=$this->_getParam('id');
	    $poi_type=$this->_getParam('poi_type');
	    $params=array('Amenities'=>array(),
	                  'Dining_Options'=>array(),
	                  'Cuisine'=>array(),
	                  'Things_options'=>array(),
	                  'Things_activity'=>array());
	    $images=array();
	    $thingsparam = array();
	    $thingsparam['param_category_desc']='';
	     
// ----------------- Get Params Filled in	    
	    
	    
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
	    	if ($poi_type=='Things')
	        {
	            $paramtable= new Users_Model_Param_Table();
	            $thingsparam=$paramtable->getparambyId($row->poi_things_type);
    	        $params['Things_options']=$row->getFacl('Things_options')->toarray();
	            $params['Things_activity']=$row->getFacl('Things_activity')->toarray();
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

	    
	    $form = new Poi_Form_Poi_Generalinfo(array('poi_id'=>$poi_id,'poi_type'=>$poi_type,    
	            'param_desc_id' => $thingsparam['param_category_desc']));
	     
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
	    if ($poi_type=='Things' and isset($facl_value['Things_options']))
	        $form->_setfaclvalue ($facl_value['Things_options'],'poi_things_options');
	    if ($poi_type=='Things' and isset($facl_value['Things_activity']))
	        $form->_setfaclvalue ($facl_value['Things_activity'],'poi_things_activity');

	    
	    
	    
	    $this->view->headScript()->appendFile('https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places');
	    $this->view->headScript()->appendFile('/js/googlemap.js');
//	    $this->view->headScript()->appendFile('/js/tabs.js');
	     
        $this->view->headLink()->appendStylesheet('/css/default/jquery-ui-1.9.1.css');
        
	    $this->view->title = 'Point Of Interest';
	    $this->view->poi_id = $poi_id;
	    $this->view->poi_type=$poi_type;
	    $this->view->images=$images;
	     
	    
	    
	    
	    if ($this->_request->isPost())
	    {
	    
	        $info= $this->_getAllParams();
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

	
	public function relatedAction() 
	{
	    $poi_id=$this->_getParam('id');
	    if (!$this->_request->isPost())
	    {
	    $poi_type=$this->_getParam('poi_type');
	    $staylist=$this->_poimodel->getPoiListbyType('Stay')->toArray();
	    $eatlist=$this->_poimodel->getPoiListbyType('Eat')->toArray();
	    $thingslist=$this->_poimodel->getPoiListbyType('Things')->toArray();
	    $relatedlist=$this->_poimodel->getrelatedPoibyType($poi_id);
	    $thispoi = $this->_poimodel->getPoibyId($poi_id)->toArray();

	    $staylist=$this->removelist($staylist,$relatedlist);
	    $eatlist=$this->removelist($eatlist,$relatedlist);
	    $thingslist=$this->removelist($thingslist,$relatedlist);

        $mykey='AIzaSyBTdIhb3x2S7P-62U2q-5EYDU1v29IyJF0';
        $this->view->headScript()->appendFile('https://maps.googleapis.com/maps/api/js?sensor=false');
        $this->view->headLink()->appendStylesheet('/css/default/jquery-ui-1.9.1.css');
        $this->view->headScript()->appendFile('/js/poimarker.js');
        
        $this->view->title = 'Related Point Of Interest';
        $this->view->poi_id = $poi_id;
        $this->view->poi_type=$poi_type;
        $this->view->related_list=$relatedlist;
        $this->view->stay_list=$staylist;
        $this->view->eat_list=$eatlist;
        $this->view->things_list=$thingslist;
        $this->view->thispoi=$thispoi;
	    }
        if ($this->_request->isPost())
        {
             
            $request = $this->getRequest ();
            $row=$request->getPost ();
            if ($row['action']=='insert')
            {
                $poi_id=$this->_poimodel->saveRelatedPoiRow($row,$poi_id);
                $this->_helper->flashMessenger('Profile Updated');
            }
            if ($row['action']=='delete')
            {
                $poi_id=$this->_poimodel->deleteRelatedPoiRow($row,$poi_id);
                $this->_helper->flashMessenger('Profile Updated');
            }
        }
	    
	    
	}
	
	public function viewAction()
	{
	    $poi_id=$this->_getParam('id');
	    $params=array('Amenities'=>array(),
	            'Dining_Options'=>array(),
	            'Cuisine'=>array());
	    $images=array();
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

	    if ($poi_type=='Stay' and isset($facl_value['Amenities']))
	        $form->_setfaclvalue ($facl_value['Amenities'],'poi_amenities');
	    if ($poi_type=='Eat' and isset($facl_value['Dining_Options']))
	        $form->_setfaclvalue ($facl_value['Dining_Options'],'poi_dining_options');
	    if ($poi_type=='Eat' and isset($facl_value['Cuisine']))
	        $form->_setfaclvalue ($facl_value['Cuisine'],'Cuisine');
	    $this->view->poi_id = $poi_id;
	    $this->view->poi_type=$poi_type;
	    $this->view->images=$images;
	    $row = $row->toArray();
	    $this->view->row=$row;
        $this->_helper->layout->disableLayout();	
	}
	
	
	
	
	private function removelist($fiestarray,$secondarray)
	{
	    $result=array();
	    $i=0;
	    foreach ($fiestarray as $row) 
	    {
	        if (!$this->in_array_r($row['poi_id'], $secondarray))
	        {
	            $result[$i++]=$row;
	        }
	                
	    }
	    return $result;
	    
	}
	
	private function in_array_r($needle, $haystack) {
	    foreach ($haystack as $item) {
	        if ($needle==$item['related_poi_id'])
	        {
	            return true;
	        }
	    }
	
	    return false;
	}

}
