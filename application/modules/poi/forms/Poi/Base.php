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
	    foreach($this->getElements() as $element)
	    {
	    
	        $element->removeDecorator('Label');
	    }
	     
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
	    $element->class='radio';
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
		$element->class='input-text required-entry';
		return $element;
	}
	protected function _poigroupname()
	{
	    $element= new Zend_Form_Element_Select ( 'poi_group_name' );
	    $element->class = 'field select medium';
	    $this->_addoptions ( $element, 'Gen', 'chain');
	     
		
		return $element;
	}
	protected function _website()
	{
		$element= new Zend_Form_Element_Text ( 'poi_web_site' );
//		$element->setLabel ( 'Web Site' );
		$element->size = '35';
		$element->maxlength = '200';
		$element->class = 'field text gf';
		$element->class='input-text';
		return $element;
	}
	protected function _contact_detail()
	{
		$element= new Zend_Form_Element_Text ( 'poi_contact_detail' );
//		$element->setLabel ( 'Contact Detail' );
		$element->size = '35';
		$element->maxlength = '200';
		$element->class = 'field text gf';
		$element->class='input-text';
		return $element;
	}	
	
	protected function _stay_type()
	{
	    $element= new Zend_Form_Element_Select ( 'poi_stay_type' );
		$element->class = 'field select medium';
		$this->_addTypeoptions($element, 'Stay');
		return $element;
	}

	protected function _poi_restaurant_type()
	{
	    $element= new Zend_Form_Element_Select ( 'poi_restaurant_type' );
		$element->class = 'field select medium';
		$this->_addTypeoptions($element, 'Eat');
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
		$element->class='input-text';
		return $element;
	}
	protected function _area()
	{
		$element= new Zend_Form_Element_Text ( 'poi_area' );
//		$element->setLabel ( 'Area' )->setRequired ( 'true' );
		$element->size = '70';
		$element->maxlength = '200';
		$element->class='input-text required-entry search-autocomplete';
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
	    $this->_addTypeoptions($element, 'Things');
	    return $element;
	}
	
	protected function _amenities()
	{
	    $element= new Zend_Form_Element_MultiCheckbox ( 'poi_amenities' );
		$this->_addpoioptions( $element, 'Amenities' );
	    return $element;
	}
	
	protected function _poi_dining_options()
	{
	    $element= new Zend_Form_Element_MultiCheckbox ( 'poi_dining_options' );
		$this->_addpoioptions ( $element, 'Dining_Options' );
	    return $element;
	}
	
	protected function _Cuisine()
	{
	    $element= new Zend_Form_Element_MultiCheckbox ( 'Cuisine' );
		$this->_addpoioptions( $element,  'Cuisine' );
	    return $element;
	}
	
	protected function _images($poi_id)
	{
		$element= new Zend_Form_Element_File ( 'poi_images' );
		//$path=APPLICATION_PATH . IMAGE_PATH."/".$poi_id.'/';
		$path=IMAGE_PATH."/".$poi_id.'/';
		//print $path;exit;
		$a=is_dir($path);
		if (!is_dir($path))
		{
		    mkdir($path);
		}
		$element->addValidator('Count', false, 1);
		// max 2MB
		$element->addValidator('Size', false, 2097152)
		->setMaxFileSize(2097152);
		// only JPEG, PNG, or GIF
		$element->setValueDisabled(true);
		
		$element->setDestination ( $path);
		$element->addValidator ( 'Extension', false, array (
				'jpg,png,gif' 
		) );
		$element->addFilter(new Ajab_Filter_File_Resize(array(
    'width' => 400,
    'height' => 300,
    'keepRatio' => true,
)));
	    return $element;
    }
	
///////////////////
    protected function _poi_things_options($param_desc_id )
    {
        $element= new Zend_Form_Element_MultiCheckbox ( 'poi_things_options' );
//        $this->_addoptions ( $element, 'Things', $param_desc_id );
        return $element;
    }
    
    protected function _poi_things_activity($param_desc_id )
    {
        $element= new Zend_Form_Element_MultiCheckbox ( 'poi_things_activity' );
//        $this->_addoptions ( $element, 'Things', $param_desc_id.'__Act' );
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
	    $table = new Params_Model_Params_Manager();
	    if ($param_classification=='Stay_Calssification')
	    {
	        $rows = $table->getStayClassificationAll();
	    }
		if ($param_classification=='Location_Type')
	    {
	        $rows = $table->getLocationtypeAll();
	    }
		if ($param_classification=='chain')
	    {
	        $rows = $table->gethotelchainAll();
	    }
	    if ($param_classification=='Country')
	    {
	        $rows = $table->getcountryAll();
	        foreach ($rows as $row)
	        {
	            $element->addMultiOption($row->country_id,
	                    $row->country_name);
	        }
	        return;
	    }
	    foreach ($rows as $row)
	        {
	            $element->addMultiOption($row->param_id,
	                    $row->param_desc);
	        }
	}
		
	protected function _addpoioptions (Zend_Form_Element $element, $option_type)
	{
	    $table = new Params_Model_Params_Manager();
	    $rows = $table->getPoiOptionTypes($option_type);
	    foreach ($rows as $row)
	    {
	        $element->addMultiOption($row->param_id,
	                $row->param_desc);
	    }
	}
	
	protected function _addTypeoptions (Zend_Form_Element $element, $param_type)
	{
	    $data_model = new Params_Model_Params_Manager();
	    if ($param_type=='Things')
	    {
	        $datas = $data_model->getTdolist();
	        $result=array();
	        $breaker = false;
	        foreach ($datas as $data)
	        {
	            $temps=$data_model->getPoiParambygroup($data->param_id);
	            foreach ($temps as $temp)
	            {
	                $result[$data->param_desc][$temp->param_id]=$temp->param_desc;
	                if (!$breaker)
	                {
	                    $default_value=$temp->param_desc;
	                    $breaker=true;
	                }
	
	            }
	        }
	        $element->setMultiOptions($result);
	        return $default_value;
	    }
	    else
	    {
	        $datas = $data_model->getPoiParambyType($param_type);
	        foreach ($datas as $data)
	        {
	                $element->addMultiOption($data->param_id,
	                        $data->param_desc);
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