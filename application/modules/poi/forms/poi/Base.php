<?php
class Poi_Form_Poi_Base extends Core_Form

{
	public function init() 
	{

	    $this->setName('PoiBaseForm')->setMethod('post');
	    $poi_id = $this->getAttrib('poi_id');
	    $poi_type = $this->getAttrib('poi_type');
	    $param_desc_id = $this->getAttrib('param_desc_id');
	    $param_default_id = 0;
	     
	     
	    $this->addElementPrefixPath(
	            'Poi_Form_poi_Validate',
	            dirname(__FILE__) . "/Validate",
	            'validate');
	     
	    $this->addElement($this->_poiname($poi_id));
	    $this->addElement($this->_poigroupname());
	    $this->addElement($this->_locationtype());
	    $this->addElement($this->_stay_type());
	    $this->addElement($this->_stay_classification());
	    $this->addElement($this->_website());
	    $this->addElement($this->_contact_detail());
	    $this->addElement($this->_country());
	    $this->addElement($this->_city());
	    $this->addElement($this->_area());
	    $this->addElement($this->_lat());
	    $this->addElement($this->_lon());
	    $this->addElement($this->_latlon());
	    
	    $this->addElement($this->_poi_restaurant_type());
	    $this->addElement($this->_poi_dining_options());
	    $this->addElement($this->_Cuisine());
	    $this->addElement($this->_poi_halal_yn());
	    $this->addElement($this->_poi_things_type($param_default_id));
	    if ($param_desc_id== '')
	    {
	        $this->addElement($this->_poi_things_options($param_default_id ));
	        $this->addElement($this->_poi_things_activity($param_default_id ));
	    } else {
	        $this->addElement($this->_poi_things_options($param_desc_id ));
	        $this->addElement($this->_poi_things_activity($param_desc_id ));
	    }
	        
	     
	    
//	    $this->addElement($this->_poi_activity_type());
//	    $this->addElement($this->_poi_working_Time());
	     
	    $this->addElement($this->_amenities());
	    $this->addElement($this->_images($poi_id));
	    $this->addElement($this->_submit());
	    return $this;
	}

	protected function _poi_halal_yn()
	{
	    $element = new Zend_Form_Element_Radio('poi_halal_yn');
	    $element->setLabel('Halal:');
	    $element->addMultiOptions(array(
	            '1' => 'Yes',
	            '2' => 'No'
	    ))
	    ->setSeparator('');
	
	    return $element;
	}
	
	
	protected function _poiname($poi_id)
	{
	
		$element = new Zend_Form_Element_Text ( 'poi_name' );
//		$element->setLabel ( 'Name' )->setRequired ( 'true' );
		$element->size = '35';
		$element->maxlength = '200';
		$element->class = 'field text gf';
		// $poi_name->addValidator('Alnum');
		return $element;
	}
	protected function _poigroupname()
	{
	    $element= new Zend_Form_Element_Text ( 'poi_group_name' );
//		$element->setLabel ( 'Group Name' );
		$element->size = '35';
		$element->maxlength = '200';
		$element->class = 'field text gf';
		// $poi_group_name->addValidator('Alnum');
		return $element;
	}
	protected function _website()
	{
		$element= new Zend_Form_Element_Text ( 'poi_web_site' );
//		$element->setLabel ( 'Web Site' );
		$element->size = '35';
		$element->maxlength = '200';
		$element->class = 'field text gf';
		return $element;
	}
	protected function _contact_detail()
	{
		$element= new Zend_Form_Element_Text ( 'poi_contact_detail' );
//		$element->setLabel ( 'Contact Detail' );
		$element->size = '35';
		$element->maxlength = '200';
		$element->class = 'field text gf';
		return $element;
	}	
	
	protected function _stay_type()
	{
	    $element= new Zend_Form_Element_Select ( 'poi_stay_type' );
		$element->class = 'field select medium';
		$this->_addoptions ( $element, 'Stay', 'Stay_Type' );
		return $element;
	}

	protected function _poi_restaurant_type()
	{
	    $element= new Zend_Form_Element_Select ( 'poi_restaurant_type' );
		$element->class = 'field select medium';
		$this->_addoptions ( $element, 'Eat', 'Restaurant_type' );
		return $element;
	}
	
	

	
	protected function _stay_classification()
	{
		$element= new Zend_Form_Element_Select ( 'poi_stay_calssification' );
		$element->class = 'field select medium';
		$this->_addoptions ( $element, 'Stay', 'Stay_Calssification' );
		return $element;
	}
	protected function _country()
	{
	    $element= new Zend_Form_Element_Select ( 'poi_country' );
		$element->class = 'field select medium';
        $this->_addoptions ( $element, 'Gen', 'Country');
		return $element;
	}
	protected function _city()
	{
		$element= new Zend_Form_Element_Text ( 'poi_city' );
//		$element->setLabel ( 'City' )->setRequired ( 'true' );
		$element->class = 'field text';
		return $element;
	}
	protected function _area()
	{
		$element= new Zend_Form_Element_Text ( 'poi_area' );
//		$element->setLabel ( 'Area' )->setRequired ( 'true' );
		$element->class = 'field text';
		$element->size = '70';
		$element->maxlength = '200';
				return $element;
	}
	
	protected function _lat()
	{
	
		$element= new Zend_Form_Element_Text ( 'poi_lat' );
//		$element->setLabel ( 'Latitude' )->setRequired ( 'true' );
		$element->class = 'field text';
		return $element;
	}
	protected function _lon()
	{
	    $element= new Zend_Form_Element_Text ( 'poi_lon' );
//		$element->setLabel ( 'Longitude ' )->setRequired ( 'true' );
		$element->class = 'field text';
		return $element;
	}
	
	protected function _latlon()
	{
	
	    $element= new Zend_Form_Element_Hidden( 'poi_latlon' );
	    //		$element->setLabel ( 'Latitude' )->setRequired ( 'true' );
	    $element->class = 'field text';
	    return $element;
	}
	
	protected function _locationtype()
	{
	    $element= new Zend_Form_Element_Select ( 'poi_location_type' );
		$element->class = 'field select medium';
		$this->_addoptions ( $element, 'Stay', 'Location_Type' );
		return $element;
	}

	protected function _poi_things_type(&$param_default_id )
	{
	    $element= new Zend_Form_Element_Select ( 'poi_things_type' );
	    $element->class = 'poi_things_type';
	    $param_default_id =$this->_addoptions ( $element, 'Things', 'TDO_Type' );
	    return $element;
	}
	
	protected function _amenities()
	{
	    $element= new Zend_Form_Element_MultiCheckbox ( 'poi_amenities' );
		$this->_addoptions ( $element, 'Stay', 'Amenities' );
	    return $element;
	}
	
	protected function _poi_dining_options()
	{
	    $element= new Zend_Form_Element_MultiCheckbox ( 'poi_dining_options' );
		$this->_addoptions ( $element, 'Eat', 'Dining_Options' );
	    return $element;
	}
	
	protected function _Cuisine()
	{
	    $element= new Zend_Form_Element_MultiCheckbox ( 'Cuisine' );
		$this->_addoptions ( $element, 'Eat', 'Cuisine' );
	    return $element;
	}
	
	protected function _images($poi_id)
	{
		$element= new Zend_Form_Element_File ( 'poi_images' );
		$path=APPLICATION_PATH . '/../public/uploads/poi/'.$poi_id.'/';
		$a=is_dir($path);
		if (!is_dir($path))
		{
		    mkdir($path);
		}
		$element->setDestination ( $path);
		$element->addValidator ( 'Extension', false, array (
				'jpg,png,gif' 
		) );
	    return $element;
    }
	
///////////////////
    protected function _poi_things_options($param_desc_id )
    {
        $element= new Zend_Form_Element_MultiCheckbox ( 'poi_things_options' );
        $this->_addoptions ( $element, 'Things', $param_desc_id );
        return $element;
    }
    
    protected function _poi_things_activity($param_desc_id )
    {
        $element= new Zend_Form_Element_MultiCheckbox ( 'poi_things_activity' );
        $this->_addoptions ( $element, 'Things', $param_desc_id.'__Act' );
        return $element;
    }
    
    
////////////////////
    
    
    
    
	protected function _submit()
	{
        $element = new Zend_Form_Element_Submit('submit');
        $element->setLabel('Save');
	    return $element;
	}
	
	protected function _addoptions (Zend_Form_Element $element, $param_type,
	        $param_classification)
	{
	    $data_model = new Users_Model_Param_Table();
	    $datas = $data_model->getParamList($param_type, $param_classification);
	    if ($param_classification=='TDO_Type')
	    {
	        $result=array();
	        $breaker = false;
	        foreach ($datas as $data)
	        {
	            $temps=$data_model->getParamList($param_type, $data->param_category_desc);
	            foreach ($temps as $temp)
	            {
	            $result[$data->param_category_desc][$temp->param_id]=$temp->param_category_desc;
	            if (!$breaker)
	            {
	                $default_value=$temp->param_category_desc;
	                $breaker=true;
	            }
	             
	            }
	        }
	        $element->setMultiOptions($result);
	        return $default_value;
	    }
	    else 
	    {
	        foreach ($datas as $data)
	        {
	            if ($data->param_published == 'P') {
	                $element->addMultiOption($data->param_id,
	                    $data->param_category_desc);
	            }
	            if ($data->param_action == 'D') {
	            $element->setValue($data->param_id);
	            }
	        }
	    }
	}
		
	
	public function _setfaclvalue(array $value = null,$name) {
	
		if (isset($value) and !is_null($value))
		{
    	    $element = $this->getElement ( $name );
	    	$element->setValue ( $value);
		}
	}
}