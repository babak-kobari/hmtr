<?php
class Poi_Form_Poi_Things extends Core_Form

{
	public function init() 
	{

	    $this->setName('PoithingsForm')->setMethod('post');
	    $poi_sub_type = $this->getAttrib('poi_sub_type');
	    	     
	     
	    $this->addElement($this->_poi_things_options($poi_sub_type));
	    $this->addElement($this->_poi_things_activity($poi_sub_type));
	     
	    $this->addElement($this->_submit());
	     
	    return $this;
	}

	
	protected function _poi_things_options($poi_sub_type )
	{
	    $element= new Zend_Form_Element_MultiCheckbox ( 'poi_things_options' );
	    $this->_addpoioptions( $element,  'Things_Options',$poi_sub_type );
	    return $element;
	}
	
	protected function _poi_things_activity($poi_sub_type  )
	{
	    $element= new Zend_Form_Element_MultiCheckbox ( 'poi_things_activity' );
	    $this->_addpoioptions( $element,  'Activity_Type',$poi_sub_type );
	    return $element;
	}
	
	
	protected function _submit()
	{
	    $element = new Zend_Form_Element_Submit('submit');
	    $element->setLabel('Save');
	    return $element;
	}
	
	protected function _addpoioptions (Zend_Form_Element $element, $option_type,$poi_sub_type = null)
	{
	    $table = new Params_Model_Params_Manager();
	    $rows = $table->getPoiOptionTypes($option_type,$poi_sub_type);
	    foreach ($rows as $row)
	    {
	        $element->addMultiOption($row->param_id,
	                $row->param_desc);
	    }
	}
}